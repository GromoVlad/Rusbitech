<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>
<body>
    <br>
    <form method="GET" action="{{ route('newsList') }}"  style="width: 1170px; margin: 20px auto">
        <h3>Фильтр по категориям:</h3>
        <div style="display: flex; margin: 10px 0">
            <div style="display: flex; align-items: center">
                <div style="margin-right: 10px;">Автор:</div>
                <select name="author">
                    <option value="0">Все авторы</option>
                    @foreach($authors as $author)
                        <option value="{{$author->id}}"
                                @if(request()->author == $author->id) selected @endif
                        >{{$author->name}}</option>
                    @endforeach
                </select>
            </div>
            <div style="display: flex; align-items: center">
                <div style="margin: 0 20px;">От:</div>
                <input type="date" class="form-control" name="date_from" placeholder="Дата от:"
                    @if(!is_null(request()->date_from))
                        value="{{request()->date_from}}"
                    @endif
                >
            </div>
            <div style="display: flex; align-items: center">
                <div style="margin: 0 20px;">До:</div>
                <input type="date" class="form-control" name="date_to" placeholder="Дата до:"
                    @if(!is_null(request()->date_to))
                       value="{{request()->date_to}}"
                    @endif
                >
            </div>
            <div style="display: flex; align-items: center">
                <div style="margin: 0 20px;">Поиск по названию:</div>
                <input type="text" class="form-control" name="newsSearch" placeholder="Поиск по названию">
            </div>
            <button class="btn btn btn-outline-info" style="margin: 0 20px;">Фильтр</button>
        </div>
    </form>
    <table class="table" style="width: 1170px; margin: 0 auto">
        <tr class="table_head">
            <th style="width: 30%">Название</th>
            <th style="width: 15%">Дата создания</th>
            <th style="width: 15%">Автор</th>
            <th style="width: 40%">Краткое описание</th>
        </tr>
        @foreach($list as $news)
            <tr class="table_body">
                <td style="width: 30%"><a href="{{ route('news', $news)}}">{{ $news->name }}</td>
                <td style="width: 15%">{{ $news->date }}</td>
                <td style="width: 15%">{{ $news->author_name }}</td>
                <td style="width: 40%">{{ $news->announce }}</td>
            </tr>
        @endforeach
    </table>
    <div style="width: 1170px; height: 100px; margin: 20px auto">
        {{$list->links()}}
    </div>
</body>
</html>
