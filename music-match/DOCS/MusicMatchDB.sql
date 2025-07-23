CREATE DATABASE MusicMatch;
GO

USE MusicMatch;
GO

-- Tabla: Location
CREATE TABLE Location (
    IdLocation INT IDENTITY(1,1) PRIMARY KEY,
    Country VARCHAR(100) NOT NULL,
    Region VARCHAR(100) NOT NULL,
    City VARCHAR(100) NOT NULL
);

-- Tabla: Genre
CREATE TABLE Genre (
    IdGenre INT IDENTITY(1,1) PRIMARY KEY,
    Name VARCHAR(50) NOT NULL,
    Description VARCHAR(255)
);

-- Tabla: User
CREATE TABLE [User] (
    IdUser INT IDENTITY(1,1) PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Email VARCHAR(150) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    PhoneNumber VARCHAR(15),
    IdLocation INT FOREIGN KEY REFERENCES Location(IdLocation),
    UserType VARCHAR(50) NOT NULL CHECK (UserType IN ('Client', 'Musician'))
);

-- Tabla: Musician
CREATE TABLE Musician (
    IdMusician INT IDENTITY(1,1) PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    IdGenre INT FOREIGN KEY REFERENCES Genre(IdGenre),
    PricePerHour DECIMAL(10, 2) NOT NULL,
    Description VARCHAR(255),
    IdLocation INT FOREIGN KEY REFERENCES Location(IdLocation),
    Rating FLOAT CHECK (Rating BETWEEN 0 AND 5)
);

-- Tabla: MusicianGenre (relación intermedia)
CREATE TABLE MusicianGenre (
    IdMusicianGenre INT IDENTITY(1,1) PRIMARY KEY,
    IdMusician INT FOREIGN KEY REFERENCES Musician(IdMusician),
    IdGenre INT FOREIGN KEY REFERENCES Genre(IdGenre)
);

-- Tabla: Availability
CREATE TABLE Availability (
    IdAvailability INT IDENTITY(1,1) PRIMARY KEY,
    StartDate DATE NOT NULL,
    EndDate DATE NOT NULL,
    IsAvailable BIT NOT NULL,
    IdMusician INT FOREIGN KEY REFERENCES Musician(IdMusician)
);

-- Tabla: PaymentMethod
CREATE TABLE PaymentMethod (
    IdPaymentMethod INT IDENTITY(1,1) PRIMARY KEY,
    MethodName VARCHAR(50) NOT NULL,
    PaymentReference VARCHAR(100)
);

-- Tabla: Booking
CREATE TABLE Booking (
    IdBooking INT IDENTITY(1,1) PRIMARY KEY,
    IdUser INT FOREIGN KEY REFERENCES [User](IdUser),
    IdMusician INT FOREIGN KEY REFERENCES Musician(IdMusician),
    BookingDate DATE NOT NULL,
    EventDate DATE NOT NULL,
    TotalPrice DECIMAL(10, 2) NOT NULL,
    IdPaymentMethod INT FOREIGN KEY REFERENCES PaymentMethod(IdPaymentMethod),
    Status VARCHAR(50) NOT NULL CHECK (Status IN ('Pending', 'Confirmed', 'Cancelled'))
);

-- Tabla: Cart
CREATE TABLE Cart (
    IdCart INT IDENTITY(1,1) PRIMARY KEY,
    IdUser INT FOREIGN KEY REFERENCES [User](IdUser),
    IdBooking INT FOREIGN KEY REFERENCES Booking(IdBooking),
    TotalAmount DECIMAL(10, 2) NOT NULL
);

-- Tabla: Review
CREATE TABLE Review (
    IdReview INT IDENTITY(1,1) PRIMARY KEY,
    IdMusician INT FOREIGN KEY REFERENCES Musician(IdMusician),
    IdUser INT FOREIGN KEY REFERENCES [User](IdUser),
    Rating INT NOT NULL CHECK (Rating BETWEEN 1 AND 5),
    Comment VARCHAR(255),
    ReviewDate DATE NOT NULL
);

-- Tabla: Transaction
CREATE TABLE [Transaction] (
    IdTransaction INT IDENTITY(1,1) PRIMARY KEY,
    IdUser INT FOREIGN KEY REFERENCES [User](IdUser),
    IdBooking INT FOREIGN KEY REFERENCES Booking(IdBooking),
    IdPaymentMethod INT FOREIGN KEY REFERENCES PaymentMethod(IdPaymentMethod),
    TransactionDate DATE NOT NULL,
    Amount DECIMAL(10, 2) NOT NULL,
    TransactionStatus VARCHAR(50) NOT NULL CHECK (TransactionStatus IN ('Successful', 'Pending', 'Failed')),
    TransactionReference VARCHAR(100)
);

-- Tabla: Invoice
CREATE TABLE Invoice (
    IdInvoice INT IDENTITY(1,1) PRIMARY KEY,
    IdTransaction INT FOREIGN KEY REFERENCES [Transaction](IdTransaction),
    InvoiceDate DATE NOT NULL,
    BillingAddress VARCHAR(255),
    TaxAmount DECIMAL(10, 2),
    TotalAmount DECIMAL(10, 2),
    DiscountApplied DECIMAL(10, 2)
);

-- Tabla: CreditCard
CREATE TABLE CreditCard (
    IdCreditCard INT IDENTITY(1,1) PRIMARY KEY,
    PaymentToken VARCHAR(255) NOT NULL,
    LastFourDigits CHAR(4) NOT NULL,
    ExpirationDate DATE NOT NULL,
    IdUser INT FOREIGN KEY REFERENCES [User](IdUser)
);

-- Tabla: PayPalAccount
CREATE TABLE PayPalAccount (
    IdPayPalAccount INT IDENTITY(1,1) PRIMARY KEY,
    PaymentToken VARCHAR(255) NOT NULL,
    PayPalEmail VARCHAR(150) NOT NULL,
    IdUser INT FOREIGN KEY REFERENCES [User](IdUser)
);

-- Tabla: BankTransfer
CREATE TABLE BankTransfer (
    IdBankTransfer INT IDENTITY(1,1) PRIMARY KEY,
    PaymentToken VARCHAR(255) NOT NULL,
    BankAccountNumber VARCHAR(50),
    BankName VARCHAR(100),
    IdUser INT FOREIGN KEY REFERENCES [User](IdUser)
);

-- Tabla: Refund
CREATE TABLE Refund (
    IdRefund INT IDENTITY(1,1) PRIMARY KEY,
    IdTransaction INT FOREIGN KEY REFERENCES [Transaction](IdTransaction),
    RefundAmount DECIMAL(10, 2) NOT NULL,
    RefundDate DATE NOT NULL,
    RefundStatus VARCHAR(50) NOT NULL CHECK (RefundStatus IN ('Processed', 'Pending'))
);

-- Tabla: PlatformEarnings
CREATE TABLE PlatformEarnings (
    IdEarning INT IDENTITY(1,1) PRIMARY KEY,
    IdBooking INT FOREIGN KEY REFERENCES Booking(IdBooking),
    CommissionPercentage DECIMAL(5, 2) NOT NULL,
    CommissionAmount DECIMAL(10, 2) NOT NULL,
    EarningDate DATE NOT NULL
);

-- Tabla: PremiumSubscription
CREATE TABLE PremiumSubscription (
    IdSubscription INT IDENTITY(1,1) PRIMARY KEY,
    IdMusician INT FOREIGN KEY REFERENCES Musician(IdMusician),
    StartDate DATE NOT NULL,
    EndDate DATE NOT NULL,
    IsActive BIT NOT NULL,
    SubscriptionType VARCHAR(50) NOT NULL CHECK (SubscriptionType IN ('Monthly', 'Yearly'))
);
