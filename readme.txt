███████╗██╗░░██╗░█████╗░███╗░░░███╗██████╗░██╗░░░░░███████╗
██╔════╝╚██╗██╔╝██╔══██╗████╗░████║██╔══██╗██║░░░░░██╔════╝
█████╗░░░╚███╔╝░███████║██╔████╔██║██████╔╝██║░░░░░█████╗░░
██╔══╝░░░██╔██╗░██╔══██║██║╚██╔╝██║██╔═══╝░██║░░░░░██╔══╝░░
███████╗██╔╝╚██╗██║░░██║██║░╚═╝░██║██║░░░░░███████╗███████╗
╚══════╝╚═╝░░╚═╝╚═╝░░╚═╝╚═╝░░░░░╚═╝╚═╝░░░░░╚══════╝╚══════╝

parametr roczny
nazwa parametru: y
zakres: 1
przykład: https://www.example.com/?id=koszty&y=1

parametr miesięczny
nazwa parametru: m
zakres: 1 - 12
przykład: https://www.example.com/?id=koszty&m=7

parametr tygodniowy
nazwa parametru: w
zakres: 1 - 52
przykład: https://www.example.com/?id=koszty&d=34

parametr dniowy
nazwa parametru: d
zakres: 1 - 365,366(zależy czy rok jest przystępny)
przykład: https://www.example.com/?id=koszty&d=12
uwaga domyślnie nie podanie dnia oddaje dzień bieżący: 
https://www.example.com/?id=koszty

sygnalizacja błedów:
 - brak id
 - błędne id
 - nie numeryczna wartość parametru czasowego
 - parametry nie mieszczą się w zakresie
 - podanie dwóch parametrów

 uwagi:
  - pytanie się o ostatni tydzień aplikacjia nie bierze pod uwagę ostatniego dnia roku