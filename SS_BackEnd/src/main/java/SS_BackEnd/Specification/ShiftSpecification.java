package SS_BackEnd.Specification;

import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Entities.Shift;
import SS_BackEnd.Forms.ProfileForms.ProfileFilterForm;
import SS_BackEnd.Forms.Shift.ShiftFilterForm;
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
public class ShiftSpecification implements Specification<Shift> {

    @NonNull
    private String field;

    @NonNull
    private Object value;

    @Override
    public Predicate toPredicate(@NotNull Root<Shift> root,
                                 @NotNull CriteriaQuery<?> query,
                                 @NonNull CriteriaBuilder criteriaBuilder) {



        if (field.equalsIgnoreCase("shiftName")) {
            return criteriaBuilder.like(root.get("shiftName"), "%" + value + "%");
        }

        if (field.equalsIgnoreCase("isActive")) {
            return criteriaBuilder.equal(root.get("isActive"), value);
        }

        if (field.equalsIgnoreCase("isOT")) {
            return criteriaBuilder.equal(root.get("isOT"),  value);
        }

        if (field.equalsIgnoreCase("targetDate")) {
            return criteriaBuilder.equal(root.get("startTime").as( java.sql.Date.class),  value);
        }


        return null;
    }

    public static Specification<Shift> buildWhere(String search, ShiftFilterForm form) {
        Specification<Shift> where = null;

        if (!StringUtils.isEmptyOrWhitespaceOnly(search)) {
            search = search.trim();
            ShiftSpecification shiftName = new ShiftSpecification("shiftName", search);
            where = Specification.where(shiftName);
        }

        if (form != null) {


            if (form.getIsActive() != null) {
                ShiftSpecification isActive = new ShiftSpecification("isActive", form.getIsActive());
                if (where != null) {
                    where = where.and(isActive);
                } else {
                    where = Specification.where(isActive);
                }
            }

            if (form.getIsOT() != null) {
                ShiftSpecification isOT = new ShiftSpecification("isOT", form.getIsOT());
                if (where != null) {
                    where = where.and(isOT);
                } else {
                    where = Specification.where(isOT);
                }
            }

            if (form.getTargetDate() != null) {
                ShiftSpecification targetDate = new ShiftSpecification("targetDate", form.getTargetDate());
                if (where != null) {
                    where = where.and(targetDate);
                } else {
                    where = Specification.where(targetDate);
                }
            }

//            if (form.getFrom() != null) {
//                ShiftSpecification from = new ShiftSpecification("from", form.getFrom());
//                if (where != null) {
//                    where = where.and(from);
//                } else {
//                    where = Specification.where(from);
//                }
//            }
//
//            if (form.getTo()!= null) {
//                ShiftSpecification to = new ShiftSpecification("to", form.getTo());
//                if (where != null) {
//                    where = where.and(to);
//                } else {
//                    where = Specification.where(to);
//                }
//            }

        }

        return where;
    }


}
