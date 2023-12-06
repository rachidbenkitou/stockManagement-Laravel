<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container">
        <h1>Listes des Produits</h1>
        @if (\Session::has('success'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Message: </strong> {{ \Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (\Session::has('fail'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Message: </strong> {{ \Session::get('fail') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex justify-content-between ">
            <form method="POST" action="{{ route('produit.search') }}" class="d-flex" role="search">
                @csrf
                <input class="form-control me-2" type="search" name="code_produit" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Ajouter Produit
            </button>
        </div>
        <!-- Start Modal Add Produit -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter Produit</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('produit.store') }}">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" class="form-control" name="code_produit" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quantite</label>
                                <input type="text" class="form-control" name="quantite" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">prix Unitaire</label>
                                <input type="text" class="form-control" name="prix_unitaire"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" name="description"
                                    aria-describedby="emailHelp">
                                <div id="emailHelp" class="form-text">We'll never share your address with anyone else.
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Modal Add Produit -->

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Code</th>
                    <th scope="col">Quantite</th>
                    <th scope="col">Prix Unitaire</th>
                    <th scope="col">Description</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @if (session('produits'))
                    <!-- Display search results -->
                    @foreach (session('produits') as $produit)
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ $produit['code_produit'] }}</td>
                            <td>{{ $produit['quantite'] }}</td>
                            <td>{{ $produit['prix_unitaire'] }}</td>
                            <td>{{ $produit['description'] }}</td>
                            <td>
                                <!-- Add any additional columns or actions for search results -->
                            </td>
                        </tr>
                    @endforeach
                @else
                    @foreach ($produits as $produit)
                        <tr>
                            
                            <th scope="row">{{$produit->id}}</th>
                            <td>{{ $produit->code_produit }}</td>
                            <td>{{ $produit->quantite }}</td>
                            <td>{{ $produit->prix_unitaire }}</td>
                            <td>{{ $produit->description }}</td>
                            <td>
                                <form action="{{ route('produit.destroy', $produit->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn">
                                        <i class="bi bi-trash text-danger" style="cursor: pointer"
                                            data-toggle="tooltip" data-placement="top" title="Supprimer">
                                        </i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                {{-- <form action="{{ route('produit.edit', $produit->id) }}" method="get"> --}}
                                {{-- @csrf
                                @method('get') --}}
                                <button type="button" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#EditModal{{ $produit->id }}">
                                    <i class="bi bi-pencil-square text-danger" style="cursor: pointer"></i>
                                </button>
                                {{-- </form> --}}
                                <!-- Start Modal Edit Produit -->
                                <div class="modal fade" id="EditModal{{ $produit->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier Peoduit
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            {{-- @if (\Session::has('produit')) --}}
                                            <form method="POST"
                                                action="{{ route('produit.update', $produit->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Code</label>
                                                        <input type="text" class="form-control" name="code_produit"
                                                            aria-describedby="emailHelp"
                                                            value="{{ $produit->code_produit }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Quantite</label>
                                                        <input type="text" class="form-control" name="quantite"
                                                            aria-describedby="emailHelp"
                                                            value="{{ $produit->quantite }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">prix Unitaire</label>
                                                        <input type="text" class="form-control"
                                                            name="prix_unitaire" aria-describedby="emailHelp"
                                                            value="{{ $produit->prix_unitaire }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Description</label>
                                                        <input type="text" class="form-control" name="description"
                                                            aria-describedby="emailHelp"
                                                            value="{{ $produit->description }}">
                                                        <div id="emailHelp" class="form-text">We'll never share your
                                                            address with anyone
                                                            else.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save
                                                        changes</button>
                                                </div>
                                            </form>
                                            {{-- @endif --}}
                                        </div>
                                    </div>
                                </div>
                                <!-- End Modal Edit Produit -->
                            </td>


                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <nav aria-label="...">
            <ul class="pagination">
              <li class="page-item" {{ $currentPage == 1 ? 'disabled' : '' }}>
                <a class="page-link" href="/produits?page={{$currentPage-1}}">Previous</a>
              </li>
              @for ($i = max(1, $currentPage - 5); $i <= min($currentPage + 4, $totalPages); $i++)
                @if($i==$currentPage)
                    <li class="page-item active" aria-current="page">
                        <a class="page-link" href="/produits?page={{$i}}">{{$i}}</a>
                    </li>
                @else
                <li class="page-item"><a class="page-link" href="/produits?page={{$i}}">{{$i}}</a></li>
                @endif
              @endfor
              <li class="page-item" {{ $currentPage == $totalPages ? 'disabled' : '' }}>
                <a class="page-link" href="/produits?page={{$currentPage+1}}">Next</a>
              </li>
            </ul>
          </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
