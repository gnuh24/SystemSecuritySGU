package SS_BackEnd.Entities;

import lombok.Data;
import lombok.NoArgsConstructor;
import jakarta.persistence.*;
import java.io.Serializable;
import java.time.LocalDateTime;

@Data
@Entity
public class FingerPrint {

    @EmbeddedId
    private FingerPrintId id;

    @Column(name = "path", nullable = false)
    private String path;

    @Column(name = "createAt", nullable = false)
    private LocalDateTime createAt = LocalDateTime.now();

    @ManyToOne
    @JoinColumn(name = "profileCode", referencedColumnName = "code", insertable = false, updatable = false)
    private Profile profile; // Assuming you have a Profile entity

    @Data
    @NoArgsConstructor
    public static class FingerPrintId implements Serializable {
        private String profileCode;
        private String imageName;
    }
}
