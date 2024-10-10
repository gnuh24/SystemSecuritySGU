package SS_BackEnd.Services.AccountServices;

import SS_BackEnd.Configuration.Exception.AuthException.*;
import SS_BackEnd.Configuration.WebSecurity.JWTUtils;
import SS_BackEnd.Entities.Account;
import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Forms.Account.AccountFilterForm;
import SS_BackEnd.Forms.Account.AccountUpdateForm;
import SS_BackEnd.Forms.Account.LoginInputForm;
import SS_BackEnd.Forms.Account.LoginOutputForm;
import SS_BackEnd.Repositories.IAccountRepository;
import SS_BackEnd.Specification.AccountSpecification;
import io.jsonwebtoken.ExpiredJwtException;
import io.jsonwebtoken.security.SignatureException;
import jakarta.persistence.EntityNotFoundException;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.security.core.authority.AuthorityUtils;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.util.HashMap;

@Service
public class AccountService implements IAccountService {

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
    public Page<Account> getAllAccountByAdmin(Pageable pageable, AccountFilterForm form, String search) {

        Specification<Account> where = AccountSpecification.buildWhere(search, form);

        return accountRepository.findAll(where, pageable);
    }

    @Override
    public Account getAccountByUsername(String username) {
        return accountRepository.findByUsername(username);
    }



    @Override
    public Account createAccount(Profile profile) {

        Account account = new Account();
        account.setUsername(profile.getCode());
        account.setPassword(passwordEncoder.encode(convertLocalDateToString(profile.getBirthday())));
        account.setProfile(profile);
        return accountRepository.save(account);
    }

    @Override
    public Account updateAccount(AccountUpdateForm form) {
        Account account = getAccountById(form.getId());

        if (account == null) {
            throw new EntityNotFoundException("Không tìm thấy account có id: " + form.getId());
        }

        account.setStatus(form.getStatus());
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
