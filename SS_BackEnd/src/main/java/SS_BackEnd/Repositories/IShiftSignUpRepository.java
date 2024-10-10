package SS_BackEnd.Repositories;

import SS_BackEnd.Entities.ShiftSignUp;
import org.springframework.data.jpa.repository.JpaRepository;

public interface IShiftSignUpRepository extends JpaRepository<ShiftSignUp, ShiftSignUp.ShiftSignUpId> {
}
