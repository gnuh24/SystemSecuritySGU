package SS_BackEnd.Configuration.WebSecurity;

import SS_BackEnd.Configuration.Exception.AuthException.AccountBannedException;
import SS_BackEnd.Configuration.Exception.AuthException.AuthExceptionHandler;
import SS_BackEnd.Configuration.Exception.AuthException.InvalidJWTSignatureException;
import SS_BackEnd.Configuration.Exception.AuthException.TokenExpiredException;
import SS_BackEnd.Entities.Account;
import SS_BackEnd.Services.IAccountService;
import io.jsonwebtoken.ExpiredJwtException;
import io.jsonwebtoken.security.SignatureException;
import jakarta.servlet.FilterChain;
import jakarta.servlet.ServletException;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.validation.constraints.NotNull;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Lazy;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.context.SecurityContext;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.web.authentication.WebAuthenticationDetailsSource;
import org.springframework.stereotype.Component;
import org.springframework.util.AntPathMatcher;
import org.springframework.web.filter.OncePerRequestFilter;

import java.io.IOException;

@Component
public class JWTAuthorizationFilter extends OncePerRequestFilter {

    @Autowired
    private JWTUtils jwtUtils;

    @Autowired
    @Lazy
    private IAccountService accountService;

    @Autowired
    private AuthExceptionHandler authExceptionHandler;

    private static final AntPathMatcher pathMatcher = new AntPathMatcher();


    @Override
    //Xác thực Token khi login và call API (Chạy đầu tiên)
    protected void doFilterInternal(HttpServletRequest request,
                                    @NotNull HttpServletResponse response,
                                    @NotNull FilterChain filterChain) throws ServletException, IOException {

        final   String authHeader = request.getHeader("Authorization");
        final   String jwtToken;
        final   String username;
        // Kiểm tra token
        if (authHeader != null && !authHeader.isBlank()) {
            /**
             * authHeader thường là 1 chuỗi thế này
             * VD: "Bearer eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJodW5nbnQuMDIwNDA0QGdtYWlsLmNvbSIsImlhdCI6MTcxMjY3Nzk3NSwiZXhwIjoxNzEyNzY0Mzc1fQ.GeODCykd-jW9_TJCocD-j8WcQ6aH6gCIo1OPGEKpwEc"
             *  -> Dùng subString cắt ra để lấy được token
             *  Hàm tách username ra từ chuỗi JWT -> Lấy được email
             */
            jwtToken = authHeader.substring(7);
            username = jwtUtils.extractUsernameWithoutLibrary(jwtToken);
            //Nếu token có thể tách được email ra && SecurityContext chưa chứ thng tin tài khoản nào
            if (username != null && SecurityContextHolder.getContext().getAuthentication() == null) {

                try {
                    // Lấy ra theo Email
                    UserDetails userDetails = accountService.loadUserByUsername(username);

                    // Kiểm tra xem tài khoản co đang bị khóa không
                    Account account = accountService.getAccountByUsername(username);
                    if (!account.getStatus()){
                        authExceptionHandler.handle(request, response, new AccountBannedException("Tài khoản của bạn đã bị khóa vì thế không thể call API !!"));
                        return;
                    }

                    if (jwtUtils.isAccessTokenValid(jwtToken, userDetails)) {
                        // Tạo SecurityContext và Authen Token
                        SecurityContext securityContext = SecurityContextHolder.createEmptyContext();
                        UsernamePasswordAuthenticationToken token = new UsernamePasswordAuthenticationToken(
                            userDetails, null, userDetails.getAuthorities()
                        );
                        token.setDetails(new WebAuthenticationDetailsSource().buildDetails(request));
                        securityContext.setAuthentication(token);
                        SecurityContextHolder.setContext(securityContext);

                    }
                }
                catch (UsernameNotFoundException e3) {
                    authExceptionHandler.commence(request, response, new UsernameNotFoundException("Token của bạn chứa thông tin không tồn tại trong hệ thống !!"));
                    return;
                }
                catch (ExpiredJwtException e1) {
                    authExceptionHandler.commence(request, response, new TokenExpiredException("Access Token của bạn đã hết hạn sử dụng !!"));
                    return;
                }
                catch (SignatureException e2){
                    authExceptionHandler.commence(request, response, new InvalidJWTSignatureException("Access Token chứa signature không hợp lệ !!"));
                    return;
                }
            }
        }


        filterChain.doFilter(request, response);
    }

}

