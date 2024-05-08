Цель
Разработать мини-проект, который по введённому кадастровому номеру получит информацию из Росреестра

Страницы сайта
Страница авторизации
Список полученных данных
Детальная страница о кадастровом номере
Форма запроса новых данных
Требования
Для хранения данных использовать любое SQL-хранилище данных (SQLite, MySQL, PostgreSQL, MSSQL);
Для реализации frontend-части использовать ReactJS или VueJS по желанию. Но приориететно - ReactJS;
Для отрисовки использовать компоненты, реализующие Material Design - Material UI, Vue Material или подобные;
Страница авторизации
Создать 5 пользователей, которые могут авторизовываться в системе, без системы ролей и прав

Список полученных данныхРеализовать БД заявок, которые доступны пользователю (отображать только те, которые внёс сам пользователь).
Внешний вид - таблица с сортировкой по любому столбцу, с постраничной навигацией.
Доступные столбцы:
ID заявки
Кадастровый номер
Адрес
Дата создания
Дата обновления
Количество собственников
Количество ограничений
Детальная страница о кадастровом номере
Должна содержать полученную информацию из открытых API росреестра:

Общая информация
Кадастровый номер XX:XX:XXXXX:XX
Дата присвоения кадастрового номера 07.11.2023
Характеристики объекта
Адрес (местоположение) Москва, ул. Ленина, д. 1, кв. 1
Площадь, кв.м 99,9
Этаж 9
Сведения о кадастровой стоимости
Кадастровая стоимость (руб) 9 999 999,99 руб
Дата определения 07.11.2023
Дата внесения 07.11.2023
Сведения о правах и ограничениях (обременениях)
Вид, номер и дата государственной регистрации права
Собственность № XXX от 07.11.2023, 1/4
Собственность № XXX от 07.11.2023, 3/4
Ограничение прав и обременение объекта недвижимости
Ипотека в силу закона № XXX от 07.11.2023
Форма запроса новых данных
Содержит 1 поле для ввода кадастрового номера и кнопки Отправить.
После отправки добавить задачу в очередь получения данных.
Раз в минуту должна запускаться команда, которая по списку задач получает данные из API росреестра и сохраняет в БД.
Предусмотреть возможность параллельного запроса информации о нескольких кадастровых номерах. Количество параллельных запросов вынести в конфиг, по-умолчанию 3.

Адреса API:
https://rosreestr.gov.ru/fir_lite_rest/api/gkn/fir_object/52:18:0070256:1560
https://rosreestr.gov.ru/fir_rest/api/fir/fir_objects/52:18:0070259:1826
https://rosreestr.gov.ru/fir_rest/api/fir/fir_egrp_object/152_272681001 (ID получен из 2 апи, права собственности отображать только с rightState=1)
