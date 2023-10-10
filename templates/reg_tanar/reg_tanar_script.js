let hibakod={$params['hibakod']};
switch(hibakod){
    case 1:
        alert('Hibás Felhasználónév!');
        break;
    case 2:
        alert('Hibás Email-cím!');
        break;
    case 3:
        alert('Hibás Telefonszám!');
        break;
    case 4:
        alert('Hibás Név!');
        break;
    case 5:
        alert('Hibás Irányítószám!');
        break;
    case 6:
        alert('Hibás Város!');
        break;
    case 7:
        alert('Hibás Cím!');
        break;
    case 8:
        alert('Hibás Jelszó!');
        break;
    case 9:
        alert('A felhasználónév már foglalt!');
        break;
    case 10:
        alert('Az Email-cím már foglalt!');
        break;
    case 11:
        alert('A két jelszó nem egyezik');
        break;
    case 11:
        alert('Nem megfelelő adószám');
        break;
    default:
        alert('Hiba a szerveren!');
        break;
}