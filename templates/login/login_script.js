let hibakod={$params['last']};
switch(hibakod){
    case 1:
        alert('Hibás Felhasználónév!');
        break;
    case 2:
        alert('Hibás Jelszó!');
        break;
    case 3:
        alert('Hibás Felhasználónév és Jelszó páros!');
        break;
    default:
        alert('Hiba a szerveren!');
        break;
}
