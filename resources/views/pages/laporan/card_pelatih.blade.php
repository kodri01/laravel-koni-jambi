<!DOCTYPE html>
<html>

<head>
    <title>Kartu Pelatih</title>
    <style>
        .member-card {
            width: 350px;
            height: 500px;
            padding-top: 5px;
            padding-left: 20px;
            padding-bottom: 20px;
            padding-right: 20px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-family: Arial, sans-serif;

            background: #2cb5a0;
            border: 4px solid #7cdacc;
            box-shadow: 0 6px 10px rgba(207, 212, 222, 1);
            border-radius: 10px;
            color: #fff;
        }

        .member-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .member-card h2 {
            font-size: 24px;
            margin: 0;
            margin-bottom: 10px;
        }

        .member-card p {
            font-size: 16px;
            margin: 5px 0;
        }

        .member-card .label {
            font-weight: bold;
        }

        .member-card .membership-number {
            margin-top: 20px;
            padding: 10px;
            background-color: #7cdacc;

            border-radius: 5px;
            font-size: 18px;
        }

        .member-card .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #999999;
        }
    </style>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</head>

<body>

    <div class="member-card">
        <h1 class="text-uppercase">KONI JAMBI</h1>
        <img class="img-thumbnail text-center" src="{{ asset('uploads/' . $user->profile_pic) }}" alt="Image News" />
        <h2>{{ $user->name }} {{ $user->lastname }}</h2>
        @foreach ($cabors as $cabor)
            @if ($cabor->id == $user->cabang_id)
                <p class="label">{{ ucfirst($cabor->name) }}</p>
            @endif
        @endforeach
        @foreach ($clubs as $club)
            @if ($club->id == $user->cabang_id)
                <p class="label"> Club : {{ ucfirst($club->club_name) }}</p>
            @endif
        @endforeach

        <p class="membership-number">38{{ $pelatih->id }} 37263</p>
    </div>

</body>

</html>
