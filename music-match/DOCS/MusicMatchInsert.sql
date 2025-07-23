use MusicMatch;

-- Insertar en Location
INSERT INTO Location (Country, Region, City) VALUES
('Mexico', 'Aguascalientes', 'Aguascalientes'),
('Mexico', 'Jalisco', 'Guadalajara'),
('USA', 'California', 'Los Angeles'),
('Canada', 'Ontario', 'Toronto'),
('Spain', 'Madrid', 'Madrid');

-- Insertar en Genre
INSERT INTO Genre (Name, Description) VALUES
('Rock', 'Música de género Rock'),
('Jazz', 'Música de género Jazz'),
('Pop', 'Música de género Pop'),
('Clásica', 'Música de género clásica'),
('Reggae', 'Música de género reggae');

-- Insertar en User
INSERT INTO [User] (Name, Email, Password, PhoneNumber, IdLocation, UserType) VALUES
('Juan Perez', 'juan.perez@example.com', 'password123', '4491234567', 1, 'Client'),
('Ana Gomez', 'ana.gomez@example.com', 'securepass', '3339876543', 2, 'Client'),
('Carlos Sanchez', 'carlos.sanchez@example.com', 'adminpass', '1234567890', 3, 'Musician'),
('Lucia Lopez', 'lucia.lopez@example.com', 'mypassword', '9988776655', 4, 'Musician'),
('Mario Fernandez', 'mario.fernandez@example.com', 'anotherpass', '4433221100', 5, 'Client');

-- Insertar en Musician
INSERT INTO Musician (Name, IdGenre, PricePerHour, Description, IdLocation, Rating) VALUES
('Carlos Sanchez', 1, 1500.00, 'Músico de rock experimentado', 3, 4.5),
('Lucia Lopez', 2, 1200.00, 'Saxofonista de jazz profesional', 4, 4.8),
('Luis Herrera', 3, 1000.00, 'Cantante pop con 5 años de experiencia', 1, 4.2),
('Sofia Morales', 4, 1800.00, 'Pianista de música clásica', 2, 4.9),
('Ramon Ortiz', 5, 800.00, 'Músico de reggae con banda propia', 5, 4.3);

-- Insertar en MusicianGenre
INSERT INTO MusicianGenre (IdMusician, IdGenre) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- Insertar en Availability
INSERT INTO Availability (StartDate, EndDate, IsAvailable, IdMusician) VALUES
('2024-12-01', '2024-12-15', 1, 1),
('2024-12-05', '2024-12-20', 1, 2),
('2024-12-10', '2024-12-25', 0, 3),
('2024-11-28', '2024-12-12', 1, 4),
('2024-12-01', '2024-12-10', 1, 5);

-- Insertar en PaymentMethod
INSERT INTO PaymentMethod (MethodName, PaymentReference) VALUES
('CreditCard', NULL),
('PayPal', NULL),
('OxxoPay', NULL),
('BankTransfer', NULL),
('DebitCard', NULL);

-- Insertar en Booking
INSERT INTO Booking (IdUser, IdMusician, BookingDate, EventDate, TotalPrice, IdPaymentMethod, Status) VALUES
(1, 1, '2024-11-20', '2024-12-05', 3000.00, 1, 'Confirmed'),
(2, 2, '2024-11-21', '2024-12-10', 3600.00, 2, 'Pending'),
(3, 3, '2024-11-22', '2024-12-15', 5000.00, 3, 'Cancelled'),
(4, 4, '2024-11-23', '2024-12-20', 5400.00, 4, 'Confirmed'),
(5, 5, '2024-11-24', '2024-12-25', 2400.00, 5, 'Pending');

-- Insertar en Cart
INSERT INTO Cart (IdUser, IdBooking, TotalAmount) VALUES
(1, 1, 3000.00),
(2, 2, 3600.00),
(3, 3, 5000.00),
(4, 4, 5400.00),
(5, 5, 2400.00);

-- Insertar en Review
INSERT INTO Review (IdMusician, IdUser, Rating, Comment, ReviewDate) VALUES
(1, 1, 5, 'Excelente servicio, muy profesional.', '2024-11-25'),
(2, 2, 4, 'Buena calidad musical, aunque llegó tarde.', '2024-11-26'),
(3, 3, 3, 'Aceptable, pero esperaba más.', '2024-11-27'),
(4, 4, 5, 'El mejor pianista que he contratado.', '2024-11-28'),
(5, 5, 4, 'Gran músico, pero la comunicación pudo mejorar.', '2024-11-29');

-- Insertar en Transaction
INSERT INTO [Transaction] (IdUser, IdBooking, IdPaymentMethod, TransactionDate, Amount, TransactionStatus, TransactionReference) VALUES
(1, 1, 1, '2024-11-25', 3000.00, 'Successful', 'TXN12345'),
(2, 2, 2, '2024-11-26', 3600.00, 'Pending', 'TXN12346'),
(3, 3, 3, '2024-11-27', 5000.00, 'Failed', 'TXN12347'),
(4, 4, 4, '2024-11-28', 5400.00, 'Successful', 'TXN12348'),
(5, 5, 5, '2024-11-29', 2400.00, 'Pending', 'TXN12349');

-- Insertar en Invoice
INSERT INTO Invoice (IdTransaction, InvoiceDate, BillingAddress, TaxAmount, TotalAmount, DiscountApplied) VALUES
(1, '2024-11-26', '123 Calle Principal, Aguascalientes', 480.00, 3000.00, 0.00),
(2, '2024-11-27', '456 Calle Secundaria, Guadalajara', 576.00, 3600.00, 0.00),
(3, '2024-11-28', '789 Calle Tercera, Los Angeles', 800.00, 5000.00, 0.00),
(4, '2024-11-29', '1011 Calle Cuarta, Toronto', 864.00, 5400.00, 0.00),
(5, '2024-11-30', '1213 Calle Quinta, Madrid', 384.00, 2400.00, 0.00);


INSERT INTO CreditCard (PaymentToken, LastFourDigits, ExpirationDate, IdUser)
VALUES 
('tok_123abc', '1234', '2025-06-30', 1),
('tok_456def', '5678', '2026-12-31', 2),
('tok_789ghi', '3456', '2024-03-15', 3),
('tok_101jkl', '9876', '2027-08-20', 4),
('tok_202mno', '4321', '2028-01-01', 5);


INSERT INTO PayPalAccount (PaymentToken, PayPalEmail, IdUser)
VALUES 
('pay_123abc', 'user1@paypal.com', 1),
('pay_456def', 'user2@paypal.com', 2),
('pay_789ghi', 'user3@paypal.com', 3),
('pay_101jkl', 'user4@paypal.com', 4),
('pay_202mno', 'user5@paypal.com', 5);


INSERT INTO BankTransfer (PaymentToken, BankAccountNumber, BankName, IdUser)
VALUES 
('btok_123abc', '1234567890', 'Bank of A', 1),
('btok_456def', '2345678901', 'Bank of B', 2),
('btok_789ghi', '3456789012', 'Bank of C', 3),
('btok_101jkl', '4567890123', 'Bank of D', 4),
('btok_202mno', '5678901234', 'Bank of E', 5);

INSERT INTO Refund (IdTransaction, RefundAmount, RefundDate, RefundStatus)
VALUES 
(1, 500.00, '2024-11-20', 'Processed'),
(2, 300.00, '2024-11-21', 'Pending'),
(3, 150.00, '2024-11-22', 'Processed'),
(4, 200.00, '2024-11-23', 'Pending'),
(5, 100.00, '2024-11-24', 'Processed');

INSERT INTO PlatformEarnings (IdBooking, CommissionPercentage, CommissionAmount, EarningDate)
VALUES 
(1, 10.00, 50.00, '2024-11-20'),
(2, 15.00, 75.00, '2024-11-21'),
(3, 12.50, 62.50, '2024-11-22'),
(4, 10.00, 40.00, '2024-11-23'),
(5, 20.00, 100.00, '2024-11-24');

INSERT INTO PremiumSubscription (IdMusician, StartDate, EndDate, IsActive, SubscriptionType)
VALUES 
(1, '2024-11-01', '2025-11-01', 1, 'Yearly'),
(2, '2024-12-01', '2025-12-01', 1, 'Yearly'),
(3, '2024-10-15', '2025-10-15', 0, 'Monthly'),
(4, '2024-09-01', '2024-12-01', 0, 'Monthly'),
(5, '2024-11-20', '2025-05-20', 1, 'Monthly');

