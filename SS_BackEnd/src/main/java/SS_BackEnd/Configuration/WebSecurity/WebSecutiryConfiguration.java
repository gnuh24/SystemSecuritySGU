package SS_BackEnd.Configuration.WebSecurity;


import SS_BackEnd.Configuration.Exception.AuthException.AuthExceptionHandler;
import SS_BackEnd.Services.AccountServices.IAccountService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.context.annotation.Lazy;

import org.springframework.http.HttpMethod;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.authentication.AuthenticationProvider;
import org.springframework.security.authentication.dao.DaoAuthenticationProvider;
import org.springframework.security.config.Customizer;
import org.springframework.security.config.annotation.authentication.configuration.AuthenticationConfiguration;
import org.springframework.security.config.annotation.web.builders.HttpSecurity;
import org.springframework.security.config.annotation.web.configuration.EnableWebSecurity;
import org.springframework.security.config.http.SessionCreationPolicy;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.security.web.SecurityFilterChain;
import org.springframework.security.web.authentication.UsernamePasswordAuthenticationFilter;
import org.springframework.web.cors.CorsConfigurationSource;
import org.springframework.security.config.annotation.web.configurers.AbstractHttpConfigurer;

@Configuration
@EnableWebSecurity
public class WebSecutiryConfiguration {

    @Autowired
    @Lazy
    private IAccountService accountService;

    @Autowired
    @Lazy
    private AuthExceptionHandler authExceptionHandler;

    @Autowired
    private JWTAuthorizationFilter jwtAuthFIlter;


    @Bean
    public SecurityFilterChain filterChain(HttpSecurity http,
                                           CorsConfigurationSource corsConfigurationSource) throws Exception {

        http
            // Loại bỏ bảo vệ CSRF
            .csrf(AbstractHttpConfigurer::disable)

            // Configure các luồng truy cập
            .authorizeHttpRequests((auth) -> auth

                // TODO: CÁC API LIÊN QUAN ĐẾN PRODUCT
                // Các API `Auth`

                .requestMatchers(HttpMethod.GET, "/api/Account/List").hasAnyAuthority("Admin")
                .requestMatchers(HttpMethod.PATCH, "/api/Account/Update").hasAnyAuthority("Admin")

                .requestMatchers(HttpMethod.POST, "/api/Auth/Login").permitAll()
                .requestMatchers(HttpMethod.POST, "/api/Auth/Refresh").permitAll()

                .requestMatchers(HttpMethod.GET, "/api/Profile/List").hasAnyAuthority("Manager")
                .requestMatchers(HttpMethod.GET, "/api/Profile/Detail").hasAnyAuthority("Manager")
                .requestMatchers(HttpMethod.POST, "/api/Profile/Create").hasAnyAuthority("Manager")
                .requestMatchers(HttpMethod.PATCH, "/api/Profile/Update").hasAnyAuthority("Manager")

                .requestMatchers(HttpMethod.GET, "/api/Shift/List").hasAnyAuthority("Manager")
                .requestMatchers(HttpMethod.GET, "/api/Shift/Detail").hasAnyAuthority("Manager")
                .requestMatchers(HttpMethod.POST, "/api/Shift/Create").hasAnyAuthority("Manager")
                .requestMatchers(HttpMethod.PATCH, "/api/Shift/Update").hasAnyAuthority("Manager")


                .requestMatchers(HttpMethod.POST, "/api/ShiftSignUp/Create").hasAnyAuthority("Manager")
                .requestMatchers(HttpMethod.DELETE, "/api/ShiftSignUp/Delete").hasAnyAuthority("Manager")

                .requestMatchers(HttpMethod.GET, "/api/CheckIn/List").hasAnyAuthority("Manager")
                .requestMatchers(HttpMethod.GET, "/api/CheckIn/Image").permitAll()
                .requestMatchers(HttpMethod.POST, "/api/CheckIn/Create").permitAll()

                .requestMatchers(HttpMethod.GET, "/api/CheckOut/List").hasAnyAuthority("Manager")
                .requestMatchers(HttpMethod.GET, "/api/CheckOut/Image").permitAll()
                .requestMatchers(HttpMethod.POST, "/api/CheckOut/Create").permitAll()

                // Xác thực tất cả các request
                .anyRequest()
                .authenticated()

            ).httpBasic(Customizer.withDefaults())

            .sessionManagement(manager -> manager.sessionCreationPolicy(SessionCreationPolicy.STATELESS))
            .authenticationProvider(authenticationProvider())

            // Add các bộ lọc
            .addFilterBefore(jwtAuthFIlter, UsernamePasswordAuthenticationFilter.class)

            .exceptionHandling((exceptionHandling) -> exceptionHandling

                // Cấu hình xử lý ngoại lệ cho trường hợp không xác thực (Login sai ^^)
                .authenticationEntryPoint(authExceptionHandler)

                // Cấu hình xử lý ngoại lệ cho trường hợp truy cập bị từ chối (Không đủ quyền)
                .accessDeniedHandler(authExceptionHandler)

            );

        return http.build();
    }

    @Bean
    public PasswordEncoder passwordEncoder() {
        return new BCryptPasswordEncoder();
    }

    @Bean
    public AuthenticationManager authenticationManager(AuthenticationConfiguration authenticationConfiguration)
        throws Exception {
        return authenticationConfiguration.getAuthenticationManager();
    }

    @Bean
    public AuthenticationProvider authenticationProvider() {
        DaoAuthenticationProvider daoAuthenticationProvider = new DaoAuthenticationProvider();
        daoAuthenticationProvider.setUserDetailsService(accountService);
        daoAuthenticationProvider.setPasswordEncoder(passwordEncoder());
        return daoAuthenticationProvider;
    }

}

