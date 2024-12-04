package SS_BackEnd.Entities;

import org.hibernate.engine.spi.SharedSessionContractImplementor;
import org.hibernate.id.IdentifierGenerator;

import java.io.Serializable;
import java.security.SecureRandom;

public class ProfileCodeGenerator implements IdentifierGenerator {

    private static final SecureRandom RANDOM = new SecureRandom();

    @Override
    public Serializable generate(SharedSessionContractImplementor session, Object obj) {
        // Tạo số ngẫu nhiên có 8 chữ số
        int number = RANDOM.nextInt(90000000) + 10000000;
        return "NV" + number;
    }
}

