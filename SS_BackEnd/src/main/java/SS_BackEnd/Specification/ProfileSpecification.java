package SS_BackEnd.Specification;

import SS_BackEnd.Entities.Profile;
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
public class ProfileSpecification implements Specification<Profile> {

    @NonNull
    private String field;

    @NonNull
    private Object value;

    @Override
    public Predicate toPredicate(@NotNull Root<Profile> root,
                                 @NotNull CriteriaQuery<?> query,
                                 @NonNull CriteriaBuilder criteriaBuilder) {


        if (field.equalsIgnoreCase("status")) {
            return criteriaBuilder.equal(root.get("status"), value);
        }

        if (field.equalsIgnoreCase("email")) {
            return criteriaBuilder.like(root.get("email"), "%" + value + "%");
        }

        if (field.equalsIgnoreCase("code")) {
            return criteriaBuilder.like(root.get("code"), "%" + value + "%");
        }


        return null;
    }

    public static Specification<Profile> buildWhere(String search, ProfileFilterForm form) {
        Specification<Profile> where = null;

        if (!StringUtils.isEmptyOrWhitespaceOnly(search)) {
            search = search.trim();
            ProfileSpecification code = new ProfileSpecification("code", search);
            ProfileSpecification email = new ProfileSpecification("email", search);

            where = Specification.where(code).or(email);
        }

        if (form != null) {


            if (form.getStatus() != null) {
                ProfileSpecification status = new ProfileSpecification("status", form.getStatus());
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
