package SS_BackEnd.Entities;

import lombok.Data;

import jakarta.persistence.*;
import lombok.NoArgsConstructor;

import java.io.Serializable;
import java.time.LocalDateTime;

@Data
@Entity
public class ShiftSignUp {

    @EmbeddedId
    private ShiftSignUpId id;

    @Column(name = "signUpTime", nullable = false)
    private LocalDateTime signUpTime = LocalDateTime.now();

    @ManyToOne
    @JoinColumn(name = "shiftId", referencedColumnName = "id", insertable = false, updatable = false)
    private Shift shift;

    @ManyToOne
    @JoinColumn(name = "profileCode", referencedColumnName = "code", insertable = false, updatable = false)
    private Profile profile;

    @Data
    @NoArgsConstructor
    public static class ShiftSignUpId implements Serializable {
        private Integer shiftId;
        private String profileCode;
    }
}



