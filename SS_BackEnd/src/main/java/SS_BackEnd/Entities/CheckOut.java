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
public class CheckOut {

    @EmbeddedId
    private CheckOutId id;

    @Column(nullable = false)
    private LocalDateTime checkOutTime = LocalDateTime.now();

    @Enumerated(EnumType.STRING)
    @Column(nullable = false)
    private Status status;

    @Column(nullable = false)
    private String image;

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
