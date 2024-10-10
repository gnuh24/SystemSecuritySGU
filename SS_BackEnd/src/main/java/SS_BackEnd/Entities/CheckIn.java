package SS_BackEnd.Entities;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import jakarta.persistence.*;
import java.io.Serializable;
import java.time.LocalDateTime;

@Data
@NoArgsConstructor
@AllArgsConstructor
@Entity
@Table(name = "CheckIn")
public class CheckIn {

    @EmbeddedId
    private CheckInId id;

    @Column(name = "checkInTime", nullable = false)
    private LocalDateTime checkInTime;

    @Enumerated(EnumType.STRING)
    @Column(name = "Status", nullable = false)
    private Status status;

    @Column(name = "image", nullable = false)
    private String image;

    // Relationship mappings
    @ManyToOne
    @MapsId("shiftId")
    @JoinColumn(name = "shiftId", referencedColumnName = "id")
    private Shift shift;

    @ManyToOne
    @MapsId("profileCode")
    @JoinColumn(name = "profileCode", referencedColumnName = "code")
    private Profile profile;

    @Embeddable
    @Data
    @NoArgsConstructor
    @AllArgsConstructor
    public static class CheckInId implements Serializable {
        @Column(name = "shiftId")
        private Integer shiftId;

        @Column(name = "profileCode")
        private String profileCode;
    }

    public enum Status{
        OnTime, Late
    }
}
