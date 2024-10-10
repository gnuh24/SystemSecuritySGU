package SS_BackEnd.Entities;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.hibernate.annotations.GenericGenerator;

import java.time.LocalDate;
import java.time.LocalDateTime;
import java.util.List;

@Entity
@Data
@NoArgsConstructor
@AllArgsConstructor
public class Profile {

    @Id
    @GeneratedValue(generator = "profile-code-generator")
    @GenericGenerator(name = "profile-code-generator", strategy = "SS_BackEnd.Entities.ProfileCodeGenerator")
    private String code;

    @Column(nullable = false)
    private LocalDate birthday;

    @Column(nullable = false)
    private Boolean status = false;

    @Column(nullable = false)
    private LocalDateTime createAt = LocalDateTime.now();

    @Column(nullable = false)
    private LocalDateTime updateAt = LocalDateTime.now();

    @Column(nullable = false)
    @Enumerated(EnumType.STRING)
    private Gender gender;

    @Column(nullable = false)
    @Enumerated(EnumType.STRING)
    private Position position = Position.Staff;

    @Column(nullable = false)
    private String fullname;

    @Column(nullable = false)
    private String phone;

    @Column(nullable = false)
    private String email;

    @OneToOne
    @JoinColumn(name = "accountId", unique = true)
    private Account account;

    @OneToMany(mappedBy = "profile")
    private List<FingerPrint> fingerPrints;

    @OneToMany(mappedBy = "profile")
    private List<ShiftSignUp> shiftSignUps;

    public enum Gender{
        Male, Female, Other
    }

    // Enum for position
    public enum Position {
            Staff,
            Manager
    }


}

