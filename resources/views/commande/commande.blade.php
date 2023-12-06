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
        <h1>Liste Commandes</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Ajouter une commande
        </button>

        @if (\Session::has('success'))
            <div style="margin-top:10px" class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Message: </strong> {{ \Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (\Session::has('fail'))
            <div style="margin-top:10px" class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Message: </strong> {{ \Session::get('fail') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- Start Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter une Commande</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('commande.store') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="date" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prix</label>
                            <input type="number" class="form-control" name="prix" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Client</label>
                            <input type="number" class="form-control" name="client_id" aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#Id</th>
                        <th scope="col">prix total</th>
                        <th scope="col">Date Commande</th>
                        <th scope="col">Action</th>

                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($commandes as $commande)
                      <tr>
                        <td scope="row">{{ $commande->id }}</td>
                        <td>{{ $commande->prix }}</td>
                        <td>{{ $commande->date_commande }}</td>
                        <td>

                        <form method="POST" action="{{ route('commande.destroy', ['commande' => $commande->id]) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link text-danger" onclick="return confirm('Are you sure you want to delete this?')">
                            <i class="bi bi-trash" data-toggle="tooltip" data-placement="top" title="Supprimer"></i>
                        </button>
                        </form>


                                    <!-- Edit button and form -->
            <button type="button" class="btn btn-link text-danger" data-bs-toggle="modal" data-bs-target="#editModal{{ $commande->id }}">
                <i class="bi bi-pencil-square" data-toggle="tooltip" data-placement="top" title="Modifier"></i>
            </button>
            <div class="modal fade" id="editModal{{ $commande->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $commande->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editModalLabel{{ $commande->id }}">Modifier une Commande</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('commande.update', ['commande' => $commande->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" class="form-control" name="date" value="{{ $commande->date_commande }}" aria-describedby="emailHelp">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Prix</label>
                                    <input type="number" class="form-control" name="prix" value="{{ $commande->prix }}" aria-describedby="emailHelp">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Client</label>
                                    <input type="number" class="form-control" name="client_id" value="{{ $commande->client_id }}" aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary">Modifier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
                        </td>
                      </tr>
                    @endforeach
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
