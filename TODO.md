# System ticketowy a'la Jira

System ticketowy pozwala na dodawanie ticketów wraz z opcjonalnymi załącznikami.
Każdy ticket składa się z tytułu, priorytetu, działu obsługi, osoby wyznaczonej do wykonania zadania (domyślnie pusty), opcjonalnego załącznika, daty dodania, daty zamknięcia, która będzie dodawać się automatycznie po odznaczeniu, że dany ticket został rozwiązany oraz daty deadline, czyli daty, do której ticket powinien zostać wykonany.

Strona oferuje możliwość przeglądania zadań dla danego użytkownika z prostym kalendarzem, zdań per dział, niezamkniętych zadań z danym priorytetem (backlog) oraz przeglądania zadań na konkretny dzień.
Każdy użytkownik ma możliwość sprawdzenia swojej listy zadań i oznaczenia, czy dane zadanie zostało zakończone.

Do wystawienia ticketu wymagane jest zalogowanie, natomiast niezalogowani użytkownicy mogą sprawdzać zadania dodane w każdym dziale. Zalogowani użytkownicy mają możliwość dodawania komentarzy do ticketów oraz mają możliwość oznaczania, że ticket został wykonany.

Na stronie dostępny jest panel administracyjny. Istnieją różne typy konta:
- administrator (może wszystko - dodawać, usuwać, edytować tickety, komentarze i działy)
- właściciel działu (może dodawać, usuwać i edytować tickety ze swojego działu, może dodawać komentarze i przypisywać osoby, może
zresetować swoje hasło)
- użytkownik (może dodawać tickety i komentarze, może rozwiązywać swoje tickety oraz może zresetować swoje hasło).

Tickety, komentarze i informacje o użytkownikach powinny być przechowywane w bazie danych, a załączniki jako osobne pliki.

# TODO

- [ ] Role użytkowników
  - [ ] Administrator
    - [ ] Tworzenie działów
    - [ ] Dodawanie użytkowników do działów
  - [ ] Kierownik działu
    - [x] Tworzenie/edytowanie/usuwanie ticketów (w swoim dziale)
    - [x] Przypisywanie osób do ticketów
  - [ ] Użytkownik
    - [ ] Dodawanie komentarzy do ticketów
    - [ ] Oznaczanie ticketu za wykonany
    - [ ] Reset hasła
  - [x] Niezalogowany
    - [x] Przeglądanie ticketów
    - [x] Logowanie
    - [x] Wylogowanie
- [ ] Permisje do odpowiednich akcji
- [ ] Ticket
  - tytuł
  - priorytet
  - dział
  - osoba (assignee)
  - załącznik
  - data dodania
  - data zamknięcia
  - data deadline
- [ ] Przechowywanie załączników w katalogu
- [x] Formularz do tworzenia nowego ticketu
- [ ] Przeglądanie ticketów
  - [ ] Dla użytkownika
  - [ ] Dla działu
  - [ ] Dla priorytetu
  - [ ] Dla konkretnego dnia
- [ ] Panel administracyjny
  - [ ] Zarządzanie kontami
  - [ ] Zarządzanie działami

# Wymagania funkcjonalne
- [x] użycie formularzy i ich funkcjonalności - odbieranie i przetwarzanie danych
- [ ] zapisywanie do pliku danych - np. zrzut bazy danych, zapis danych z formularza itp.
- [x] zapisywanie do bazy danych
- [x] odczytywanie z bazy danych
- [x] update i usuwanie z bazy danych
- [x] system logowania
- [x] użycie sesji w projekcie, nie sztuczne, tylko takie by pozwalało realnie zobrazować ich funkcjonalność
- [ ] użycie ciasteczek - utworzenie oraz realne skorzystanie z nich
- [x] użycie pętli, instrukcje warunkowe, tablice, funkcji
- [x] projekt realizujemy w oparciu o programowanie obiektowe
- [x] użycie czegoś z PHP, co nie było pokazywane na zajęciach - biblioteka, narzędzie, konstrukcja, temat (wymagane omówienie) (dodatkowe)
- [ ] hostowanie strony na serwerze zewnętrznym (dodatkowe)

# Wymagania niefunkcjonalne
- [ ] Przejrzysty kod - np. rozbicie na pliki, klasy, metody, stosowanie pętli zamiast printowania na sztywno
- [ ] Brak widocznych błędów komunikowanych przez język
- [ ] Projekt się “kompiluje” - brak problemów przy oddawaniu projektu
- [ ] “Ładny”/przejrzysty projekt - np. ładnie sformatowany formularz, jednolity; widok strony bez zbędnych elementów, czy rozjeżdżających się komponentówpp
