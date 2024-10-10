package SS_BackEnd.Entities;

import lombok.Data;

import jakarta.persistence.*;
import java.time.LocalDateTime;
import java.util.List;

@Data
@Entity
public class Shift {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @Column(nullable = false)
    private String shiftName;

    @Column(nullable = false)
    private LocalDateTime createAt = LocalDateTime.now();

    @Column(nullable = false)
    private LocalDateTime updateAt = LocalDateTime.now();

    @Column(nullable = false)
    private LocalDateTime startTime;

    @Column(nullable = false)
    private LocalDateTime endTime;

    @Column(nullable = false)
    private LocalDateTime breakStartTime;

    @Column(nullable = false)
    private LocalDateTime breakEndTime;

    @Column(nullable = false)
    private Boolean isActive = true;

    @Column(nullable = false)
    private Boolean isOT = false;

    @OneToMany(mappedBy = "shift")
    private List<ShiftSignUp> signUps;

}
