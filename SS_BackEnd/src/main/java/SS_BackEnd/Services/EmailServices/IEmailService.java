package SS_BackEnd.Services.EmailServices;

import SS_BackEnd.Entities.CheckIn;

public interface IEmailService {

    void sendWarningEmail(CheckIn checkIn);

}
