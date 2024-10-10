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
@Table(name = "CheckOut")
public class CheckOut {

    @EmbeddedId
    private CheckOutId id;

    @Column(name = "checkOutTime", nullable = false)
    private LocalDateTime checkOutTime;

    @Enumerated(EnumType.STRING) // Store as string in the database
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
    public static class CheckOutId implements Serializable {
        @Column(name = "shiftId")
        private Integer shiftId;

        @Column(name = "profileCode")
        private String profileCode;
    }

    public enum Status{
        OnTime, LeavingEarly
    }
}
