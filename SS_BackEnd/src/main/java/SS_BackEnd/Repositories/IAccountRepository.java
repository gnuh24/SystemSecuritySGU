package SS_BackEnd.Repositories;
import SS_BackEnd.Entities.Account;
import org.springframework.data.jpa.repository.JpaRepository;

public interface IAccountRepository extends JpaRepository<Account, Integer> {
    Account findByUsername(String username);
}
