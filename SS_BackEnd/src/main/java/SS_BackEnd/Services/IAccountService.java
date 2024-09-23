package SS_BackEnd.Services;

import SS_BackEnd.Configuration.Exception.AuthException.AccountBannedException;
import SS_BackEnd.Configuration.Exception.AuthException.InvalidCredentialsException;
import SS_BackEnd.Entities.Account;
import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Forms.Account.LoginInputForm;
import SS_BackEnd.Forms.Account.LoginOutputForm;
import org.springframework.security.core.userdetails.UserDetailsService;

public interface IAccountService extends UserDetailsService {
    Account getAccountByUsername(String username);

    Account createAccount(Profile profile);

    Account getAccountById(Integer id);

    Account updateAccount(Integer id, Boolean status);

    LoginOutputForm signInForUser(LoginInputForm signinRequest) throws InvalidCredentialsException, AccountBannedException;

    LoginOutputForm refreshToken(String token, String refreshToken) throws InvalidCredentialsException, AccountBannedException;

}