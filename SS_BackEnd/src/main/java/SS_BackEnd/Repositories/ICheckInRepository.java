package SS_BackEnd.Repositories;

import SS_BackEnd.Entities.CheckIn;
import SS_BackEnd.Entities.Shift;
import org.springframework.data.jpa.repository.JpaRepository;

public interface ICheckInRepository extends JpaRepository<CheckIn, CheckIn.CheckInId> {
}
