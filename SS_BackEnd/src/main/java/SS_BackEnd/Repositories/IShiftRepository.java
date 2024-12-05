package SS_BackEnd.Repositories;

import SS_BackEnd.Entities.Shift;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

import java.util.List;

public interface IShiftRepository extends JpaRepository<Shift, Integer>, JpaSpecificationExecutor<Shift> {
    @Query(value = "SELECT * " +
        "FROM Shift " +
        "WHERE isActive = 1 " +
        "AND :inputTime BETWEEN startTime AND endTime",
        nativeQuery = true)
    List<Shift> findShiftsByTime(@Param("inputTime") String inputTime);
}
