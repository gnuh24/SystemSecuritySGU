package SS_BackEnd.Repositories;

import SS_BackEnd.Entities.CheckIn;
import SS_BackEnd.Entities.CheckOut;
import org.springframework.data.jpa.repository.JpaRepository;

public interface ICheckOutRepository extends JpaRepository<CheckOut, CheckOut.CheckOutId> {
}
