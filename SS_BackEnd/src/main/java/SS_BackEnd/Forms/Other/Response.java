package SS_BackEnd.Forms.Other;

import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
public class Response<T> {

    private Integer status;

    private String message;

    private T data;

}
