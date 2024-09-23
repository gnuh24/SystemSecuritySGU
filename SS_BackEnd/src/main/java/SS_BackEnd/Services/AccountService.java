package SS_BackEnd.Services;

import SS_BackEnd.Configuration.Exception.AuthException.*;
import SS_BackEnd.Configuration.WebSecurity.JWTUtils;
import SS_BackEnd.Entities.Account;
import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Forms.Account.LoginInputForm;
import SS_BackEnd.Forms.Account.LoginOutputForm;
import SS_BackEnd.Repositories.IAccountRepository;
import io.jsonwebtoken.ExpiredJwtException;
import io.jsonwebtoken.security.SignatureException;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.authority.AuthorityUtils;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.util.HashMap;

@Service
public class AccountService implements IAccountService{

    @Autowired
    private IAccountRepository accountRepository;

    @Autowired
    private ModelMapper modelMapper;

    @Autowired
    private PasswordEncoder passwordEncoder;

    @Autowired
    private JWTUtils jwtUtils;

    @Override
    public LoginOutputForm signInForUser(LoginInputForm signinRequest) throws InvalidCredentialsException, AccountBannedException {
        LoginOutputForm response = new LoginOutputForm();

        Account user = getAccountByUsername(signinRequest.getUsername());

        if (user == null) {
            throw new InvalidCredentialsException("Email hoặc mật khẩu không đúng !!");
        }

        if (!passwordEncoder.matches(signinRequest.getPassword(), user.getPassword())) {
            throw new InvalidCredentialsException("Email hoặc mật khẩu không đúng !!");
        }

        if (!user.getStatus()){
            throw new AccountBannedException("Tài khoản của bạn đã bị khóa !! Nếu có vấn đề xin vui lòng liên hệ Admin");
        }

        //Tạo Token
        String jwt = jwtUtils.generateToken(user);
        response.setToken(jwt);
        response.setTokenExpirationTime("30 phút");

        //Tạo refresh token
        String refreshToken = jwtUtils.generateRefreshToken(new HashMap<>(), user);
        response.setRefreshToken(refreshToken);
        response.setRefreshTokenExpirationTime("7 ngày");

        response.setId(user.getId());
        response.setUsername(user.getUsername());
        response.setRole(user.getRole().toString());

        return response;
    }

    @Override
    public LoginOutputForm refreshToken(String token, String refreshToken) {

        LoginOutputForm response = new LoginOutputForm();

//        if(logoutJWTTokenService.isThisTokenLogouted(refreshToken)){
//            throw new LoggedOutTokenException("Refresh Token đã bị vô hiệu hóa vì thế không sử dụng được nữa !!");
//        }

        //Lấy Email từ Token (Dùng hàm viết tay -> Vì hàm có sẵn sẽ tự kiểm tra thời hạn của Token cũ)
        String emailFromOldToken = jwtUtils.extractUsernameWithoutLibrary(token);
        String emailFromRefreshToken = jwtUtils.extractUsernameWithoutLibrary(refreshToken);

        if (!emailFromRefreshToken.equals(emailFromOldToken)){
            throw new MismatchedTokenAccountException("Access Token và Refresh Token không cùng 1 chủ sở hữu !!");
        }

        //Tìm tài khoản dựa trên Email
        Account account = getAccountByUsername(emailFromRefreshToken);
        try{
            if (jwtUtils.isRefreshTokenValid(refreshToken, account)) {
                //Set Token mới
                var jwt = jwtUtils.generateToken(account);
                response.setToken(jwt);
                response.setTokenExpirationTime("30 phút");
            }
        }
        catch (ExpiredJwtException e1) {
            throw new TokenExpiredException("Refresh Token của bạn đã hết hạn sử dụng !!");
        }
        catch (SignatureException e2){
            throw new InvalidJWTSignatureException("Refresh Token chứa signature không hợp lệ !!");
        }

        return response;

    }


    @Override
    public UserDetails loadUserByUsername(String username) throws UsernameNotFoundException {
        Account account = getAccountByUsername(username);

        if (account == null) {
            throw new UsernameNotFoundException(username);
        }

        return new org.springframework.security.core.userdetails.User(
            account.getUsername(),
            account.getPassword(),
            AuthorityUtils.createAuthorityList(account.getRole().toString())
        );
    }

    @Override
    public Account getAccountByUsername(String username) {
        return accountRepository.findByUsername(username);
    }

    @Override
    public Account createAccount(Profile profile) {

        Account account = new Account();
        account.setUsername(profile.getPhone());
        account.setPassword(passwordEncoder.encode(convertLocalDateToString(profile.getBirthday())));
        account.setProfile(profile);
        return accountRepository.save(account);
    }

    @Override
    public Account updateAccount(Integer id, Boolean status) {
        Account account = getAccountById(id);
        account.setStatus(status);
        return accountRepository.save(account);
    }

    @Override
    public Account getAccountById(Integer id) {
        return accountRepository.findById(id).orElse(null);
    }

    private String convertLocalDateToString(LocalDate date) {
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("ddMMyyyy");
        return date.format(formatter);
    }
}
