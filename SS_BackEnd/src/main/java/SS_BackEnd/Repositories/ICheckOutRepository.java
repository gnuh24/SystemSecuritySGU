package SS_BackEnd.Repositories;

import SS_BackEnd.Entities.CheckIn;
import SS_BackEnd.Entities.CheckOut;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface ICheckOutRepository extends JpaRepository<CheckOut, CheckOut.CheckOutId> {

    List<CheckOut> findAllByIdShiftId(Pageable pageable, Integer shiftId);


}
