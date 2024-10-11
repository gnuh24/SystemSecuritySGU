package SS_BackEnd.Repositories;

import SS_BackEnd.Entities.CheckIn;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface ICheckInRepository extends JpaRepository<CheckIn, CheckIn.CheckInId> {

    List<CheckIn> findAllByIdShiftId(Pageable pageable, Integer shiftId);

}
