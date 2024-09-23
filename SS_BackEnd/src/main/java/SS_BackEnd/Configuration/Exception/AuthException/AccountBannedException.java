package SS_BackEnd.Configuration.Exception.AuthException;

import org.springframework.security.access.AccessDeniedException;
import org.springframework.security.core.AuthenticationException;

public class AccountBannedException extends AccessDeniedException {
    public AccountBannedException(String message) {
        super(message);
    }
}
