<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body>
        <table style="width: 1170px; margin: 0 auto">
            <tr>
                <td style="width: 15%;">Название:</td>
                <td>{{ $info->name }}</td>
            </tr>
            <tr>
                <td style="width: 15%;">Дата создания:</td>
                <td>{{ $info->date }}</td>
            </tr>
            <tr>
                <td style="width: 15%;">Подробное описание:</td>
                <td>{{ $info->content }}</td>
            </tr>

            <tr>
                <td style="width: 15%;">Имя автора:</td>
                <td>{{ $info->author_name }}</td>
            </tr>
            <tr>
                <td style="width: 15%;">Рейтинг автора:</td>
                <td>{{ $info->rating }}</td>
            </tr>
            <tr>
                <td style="width: 15%;">Количество статей:</td>
                <td>{{ $info->count_news }}</td>
            </tr>
        </table>
    </body>
</html>
