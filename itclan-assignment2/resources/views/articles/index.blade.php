@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="font-weight-bold">Article List</h4>
                            </div>

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table article-list">
                                    <thead>
                                    <tr>
                                        <th scope="col">Sl</th>
                                        <th scope="col">Author</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Url</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Content</th>
                                        <th scope="col">Created At</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')

    <script>

        setTimeout(() => {
            $.get('articles_url', function (response, status) {
                if (response.status === 'ok') {
                    let tableRows = response.articles.map((article, index) => {
                        return "<tr>"
                            + "<td>" + ++index + "</td>"
                            + "<td>" + article.author + "</td>"
                            + "<td>" + article.title + "</td>"
                            + "<td>" + article.description + "</td>"
                            + "<td>" + "<a href=" + article.url + " target=" + "_blank" + ">Click" + "<a/>" + "</td>"
                            + "<td>" + "<img src=" + article.urlToImage + " class=" + "img-fluid" + ">" + "</td>"
                            + "<td>" + article.content + "</td>"
                            + "<td>" + article.publishedAt + "</td>"
                            + "</tr>";
                    });
                    $("table.article-list tbody").append(tableRows);
                }
            });

        }, 1000)


    </script>

@endpush
