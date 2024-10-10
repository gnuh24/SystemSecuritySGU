package SS_BackEnd.Services;

import SS_BackEnd.Entities.ShiftSignUp;

import java.util.List;

public interface IShiftSignUpService {

    List<ShiftSignUp> createSignUp(Integer shiftId, List<String> listProfile);
}
