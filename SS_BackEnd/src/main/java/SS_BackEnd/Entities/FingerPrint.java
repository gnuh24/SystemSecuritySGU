package SS_BackEnd.Entities;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Entity
@Data
@NoArgsConstructor
@AllArgsConstructor
public class FingerPrint {

    @Id
    @Column(length = 10)
    private String profileCode;

    @Column(nullable = false)
    private String path;

    @Column(nullable = false)
    private LocalDateTime createAt = LocalDateTime.now();

    @ManyToOne
    @JoinColumn(name = "profileCode", insertable = false, updatable = false)
    private Profile profile;
}

