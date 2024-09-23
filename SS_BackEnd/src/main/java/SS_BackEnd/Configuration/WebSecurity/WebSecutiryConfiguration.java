//package SS_BackEnd.Configuration.WebSecurity;
//
//
//import org.springframework.beans.factory.annotation.Autowired;
//import org.springframework.context.annotation.Bean;
//import org.springframework.context.annotation.Configuration;
//import org.springframework.context.annotation.Lazy;
//import org.springframework.http.HttpMethod;
//
//import org.springframework.security.authentication.AuthenticationManager;
//import org.springframework.security.authentication.AuthenticationProvider;
//import org.springframework.security.authentication.dao.DaoAuthenticationProvider;
//import org.springframework.security.config.annotation.authentication.configuration.AuthenticationConfiguration;
//import org.springframework.security.config.annotation.web.builders.HttpSecurity;
//import org.springframework.security.config.annotation.web.configuration.EnableWebSecurity;
//import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
//import org.springframework.security.crypto.password.PasswordEncoder;
//import org.springframework.security.web.SecurityFilterChain;
//import org.springframework.web.cors.CorsConfigurationSource;
//
//@Configuration
//@EnableWebSecurity
//public class WebSecutiryConfiguration {
//
////    @Autowired
////    @Lazy
////    private IAccountService accountService;
//
////    @Autowired
////    @Lazy
////    private AuthExceptionHandler authExceptionHandler;
//
////    @Autowired
////    private JWTAuthorizationFilter jwtAuthFIlter;
//
//
//    @Bean
//    public SecurityFilterChain filterChain(HttpSecurity http,
//                                           CorsConfigurationSource corsConfigurationSource) throws Exception {
//
//        http
//            // Loại bỏ bảo vệ CSRF
//            .csrf(AbstractHttpConfigurer::disable)
//
//            // Configure các luồng truy cập
//            .authorizeHttpRequests((auth) -> auth
//
//                // TODO: CÁC API LIÊN QUAN ĐẾN PRODUCT
//                // Các API `Brand`
////                .requestMatchers(HttpMethod.GET, "/Brand/noPaging").permitAll()
////                .requestMatchers(HttpMethod.GET, "/Brand").permitAll()
////                .requestMatchers(HttpMethod.GET, "/Brand/{brandId}").permitAll()
////                .requestMatchers(HttpMethod.GET, "/Brand/Image/{logo}").permitAll()
////                .requestMatchers(HttpMethod.POST, "/Brand").hasAnyAuthority("Admin")
////                .requestMatchers(HttpMethod.PATCH, "/Brand").hasAnyAuthority("Admin")
////                .requestMatchers(HttpMethod.DELETE, "/Brand/{brandId}").hasAnyAuthority("Admin")
//
//                // Xác thực tất cả các request
//                .anyRequest()
//                .authenticated()
//
//            ).httpBasic(Customizer.withDefaults())
//
//            .sessionManagement(manager -> manager.sessionCreationPolicy(SessionCreationPolicy.STATELESS))
//            .authenticationProvider(authenticationProvider())
//
//            // Add các bộ lọc
//            .addFilterBefore(jwtAuthFIlter, UsernamePasswordAuthenticationFilter.class)
//            .addFilterBefore(logoutAuthFilter, UsernamePasswordAuthenticationFilter.class)
//
//            .exceptionHandling((exceptionHandling) -> exceptionHandling
//
//                // Cấu hình xử lý ngoại lệ cho trường hợp không xác thực (Login sai ^^)
//                .authenticationEntryPoint(authExceptionHandler)
//
//                // Cấu hình xử lý ngoại lệ cho trường hợp truy cập bị từ chối (Không đủ quyền)
//                .accessDeniedHandler(authExceptionHandler)
//
//            )
//            .oauth2Login(oauth -> {
//                oauth.loginPage("/Auth/SignIn");
//                oauth.successHandler(handler);
//            });
//
//        return http.build();
//    }
//
//    @Bean
//    public PasswordEncoder passwordEncoder() {
//        return new BCryptPasswordEncoder();
//    }
//
//    @Bean
//    public AuthenticationManager authenticationManager(AuthenticationConfiguration authenticationConfiguration)
//        throws Exception {
//        return authenticationConfiguration.getAuthenticationManager();
//    }
//
//    @Bean
//    public AuthenticationProvider authenticationProvider() {
//        DaoAuthenticationProvider daoAuthenticationProvider = new DaoAuthenticationProvider();
//        daoAuthenticationProvider.setUserDetailsService(accountService);
//        daoAuthenticationProvider.setPasswordEncoder(passwordEncoder());
//        return daoAuthenticationProvider;
//    }
//
//}
//
