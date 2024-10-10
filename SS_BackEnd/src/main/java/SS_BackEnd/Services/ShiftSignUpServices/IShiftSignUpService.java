package SS_BackEnd.Services.ShiftSignUpServices;

import SS_BackEnd.Entities.ShiftSignUp;
import SS_BackEnd.Forms.ShiftSignUp.ShiftSignUpCreateForm;

import java.util.List;

public interface IShiftSignUpService {

    void createSignUp(Integer shiftId, List<String> listProfile);
    List<ShiftSignUp> createSignUp(ShiftSignUpCreateForm form);
    void deleteSignUp(Integer shiftId, String profileCode);

}
