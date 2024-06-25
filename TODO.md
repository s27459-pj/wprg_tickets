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
    - [ ] Tworzenie/edytowanie/usuwanie ticketów (w swoim dziale)
    - [ ] Przypisywanie osób do ticketów
  - [ ] Użytkonik
    - [ ] Dodawanie komentarzy do ticketów
    - [ ] Oznaczanie ticketu za wykonany
    - [ ] Reset hasła
  - [ ] Niezalogowany
    - [ ] Przeglądanie ticketów
    - [ ] Logowanie
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
- [ ] Formularz do tworzenia nowego ticketu
- [ ] Przeglądanie ticketów
  - [ ] Dla użytkownika
  - [ ] Dla działu
  - [ ] Dla priorytetu
  - [ ] Dla konkretnego dnia
- [ ] Panel administracyjny
  - [ ] Zarządzanie kontami
  - [ ] Zarządzanie działami
