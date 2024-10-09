package SS_BackEnd.Specification;
import SS_BackEnd.Entities.Account;
import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Forms.Account.AccountFilterForm;
import SS_BackEnd.Forms.ProfileForms.ProfileFilterForm;
import com.mysql.cj.util.StringUtils;
import jakarta.persistence.criteria.CriteriaBuilder;
import jakarta.persistence.criteria.CriteriaQuery;
import jakarta.persistence.criteria.Predicate;
import jakarta.persistence.criteria.Root;
import jakarta.validation.constraints.NotNull;
import lombok.Data;
import lombok.NonNull;
import org.springframework.data.jpa.domain.Specification;

@Data
public class AccountSpecification implements Specification<Account> {

    @NonNull
    private String field;

    @NonNull
    private Object value;

    @Override
    public Predicate toPredicate(@NotNull Root<Account> root,
                                 @NotNull CriteriaQuery<?> query,
                                 @NonNull CriteriaBuilder criteriaBuilder) {


        if (field.equalsIgnoreCase("status")) {
            return criteriaBuilder.equal(root.get("status"), value);
        }

        if (field.equalsIgnoreCase("username")) {
            return criteriaBuilder.like(root.get("username"), "%" + value + "%");
        }

        return null;
    }

    public static Specification<Account> buildWhere(String search, AccountFilterForm form) {
        Specification<Account> where = null;

        if (!StringUtils.isEmptyOrWhitespaceOnly(search)) {
            search = search.trim();
            AccountSpecification code = new AccountSpecification("username", search);
            where = Specification.where(code);
        }

        if (form != null) {


            if (form.getStatus() != null) {
                AccountSpecification status = new AccountSpecification("status", form.getStatus());
                if (where != null) {
                    where = where.and(status);
                } else {
                    where = Specification.where(status);
                }
            }


        }

        return where;
    }


}
