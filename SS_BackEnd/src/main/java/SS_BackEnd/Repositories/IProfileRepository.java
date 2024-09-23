package SS_BackEnd.Repositories;

import SS_BackEnd.Entities.Profile;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;

public interface IProfileRepository extends JpaRepository<Profile, String>, JpaSpecificationExecutor<Profile> {
}
