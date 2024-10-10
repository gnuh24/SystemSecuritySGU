package SS_BackEnd.Repositories;

import SS_BackEnd.Entities.Shift;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;

public interface IShiftRepository extends JpaRepository<Shift, Integer>, JpaSpecificationExecutor<Shift> {
}
