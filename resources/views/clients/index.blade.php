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
    <h1>Liste des clients</h1>
    <!-- Button trigger modal -->
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
        <form method="POST" action="{{ route('client.search') }}" class="d-flex" role="search">
            @csrf
            <input class="form-control me-2" type="search" name="firstName" placeholder="Prénom" aria-label="Search">
            <input class="form-control me-2" type="search" name="lastName" placeholder="Nom" aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">Recherche</button>
        </form>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Ajouter client
        </button>
    </div>

    <!-- Start Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Employee</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                 <form method="POST" action="{{ route('client.store') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" class="form-control" name="firstName" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-control" name="lastName" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" class="form-control" name="phone" aria-describedby="emailHelp">

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="adresse" aria-describedby="emailHelp">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
                 </form>
            </div>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Prénom</th>
            <th scope="col">Nom</th>
            <th scope="col">Email</th>
            <th scope="col">Téléphone</th>
            <th scope="col">Adresse</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @if (session('clients'))
            <!-- Display search results -->
            @foreach (session('clients') as $client)
                <tr>
                    <th scope="row">1</th>
                    <td>{{ $client['firstName'] }}</td>
                    <td>{{ $client['lastName'] }}</td>
                    <td>{{ $client['email'] }}</td>
                    <td>{{ $client['phone'] }}</td>
                    <td>{{ $client['adresse'] }}</td>
                    <td>
                        <!-- Add any additional columns or actions for search results -->
                    </td>
                </tr>
            @endforeach
        @else
        @foreach ($clients as $client)
            <tr>
                <th scope="row">1</th>
                <td>{{ $client->firstName }}</td>
                <td>{{ $client->lastName }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->phone }}</td>
                <td>{{ $client->adresse }}</td>
                <td>
                    <form method="POST" action="{{ route('client.destroy', $client->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link text-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">
                            <i class="bi bi-trash text-danger" style="cursor: pointer" data-toggle="tooltip" data-placement="top"
                               title="Supprimer"></i>
                        </button>
                    </form>

                </td>
                <td> <!-- Edit button and form -->
                    <button type="button" class="btn" data-bs-toggle="modal"
                            data-bs-target="#EditModal{{ $client->id }}">
                        <i class="bi bi-pencil-square text-danger" style="cursor: pointer"></i>
                    </button>
                    {{-- </form> --}}
                    <!-- Start Modal Edit Produit -->
                    <div class="modal fade" id="EditModal{{ $client->id }}" tabindex="-1"
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
                                      action="{{ route('client.update', $client->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Prénom</label>
                                            <input type="text" class="form-control" name="firstName"
                                                   aria-describedby="emailHelp"
                                                   value="{{ $client->firstName}}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nom</label>
                                            <input type="text" class="form-control" name="lastName"
                                                   aria-describedby="emailHelp"
                                                   value="{{ $client->lastName }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control"
                                                   name="email" aria-describedby="emailHelp"
                                                   value="{{ $client->email}}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Téléphone</label>
                                            <input type="text" class="form-control" name="phone"
                                                   aria-describedby="emailHelp"
                                                   value="{{ $client->phone}}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control" name="adresse"
                                                   aria-describedby="emailHelp"
                                                   value="{{ $client->adresse}}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Modifier</button>
                                    </div>
                                </form>
                                {{-- @endif --}}
                            </div>
                        </div>
                    </div>


                   </td>


            </tr>
        @endforeach
        @endif
        </tbody>
    </table>

</div>
<!-- End Modal -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>
</body>

</html>
<style>
    .bi-trash:hover {
        color: #f89797 !important; /* La couleur que vous souhaitez lors du survol */
    }
</style>
