package SS_BackEnd.Repositories;

import SS_BackEnd.Entities.FingerPrint;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface IFingerPrintRepository extends JpaRepository<FingerPrint, FingerPrint.FingerPrintId> {
    List<FingerPrint> findByProfileCode(String profileCode);
}
