<!DOCTYPE html>
<html>
<head>
    <title>Ad Details</title>
</head>
<body>
<div style="padding: 3px;"><strong>Subject:</strong> {{ $details['subject'] }}</div>
<div style="padding: 3px;"><strong>Name:</strong> {{ $details['name'] }}</div>
<div style="padding: 3px;"><strong>Company:</strong> {{ $details['company'] }}</div>
<div style="padding: 3px;"><strong>Location details:</strong> {{ $details['address'] }}</div>
<div style="padding: 3px;"><strong>Email:</strong> {{ $details['email'] }}</div>
<div style="padding: 3px;"><strong>Your Line id:</strong> {{ $details['lineId'] }}</div>
<div style="padding: 3px;"><strong>Three selected categories:</strong> {{ is_array($details['categories']) ? implode(', ', $details['categories']) : $details['categories'] }}</div>
<div style="padding: 3px;"><strong>Location Ref:</strong> {{ $details['locationRef'] }}</div>
<div style="padding: 3px;"><strong>Get on the map with:</strong> {{ is_array($details['placeType']) ? implode(', ', $details['placeType']) : $details['placeType'] }}</div>
<div style="padding: 3px;"><strong>Place pin at your location:</strong> {{ $details['pinLocation'] }}</div>
<div style="padding: 3px;"><strong>Coordinate X:</strong> {{ $details['coordinateX'] }}</div>
<div style="padding: 3px;"><strong>Coordinate Y:</strong> {{ $details['coordinateY'] }}</div>
<div style="padding: 3px;"><strong>Use exterior photo of premises with title only:</strong> {{ $details['freePic'] }}</div>
<div style="padding: 3px;"><strong>Number of Display windows:</strong> {{ $details['displayWindows'] }}</div>
<div style="padding: 3px;"><strong>1st Artwork FREE others £20.00 each x:</strong> {{ $details['artworkCountPrice'] }}</div>
<div style="padding: 3px;"><strong>Display window £10.00 per month x:</strong> {{ $details['displayWindowsPrice'] }}</div>
<div style="padding: 3px;"><strong>Display window £55.00 per year x:</strong> {{ $details['displayWindowsPriceYear'] }}</div>
<div style="padding: 3px;"><strong>Logo at location £10.00 per month x:</strong> {{ $details['logoAtLocationMonth'] }}</div>
<div style="padding: 3px;"><strong>Logo at location £80.00 per year:</strong> {{ $details['logoAtLocation'] }}</div>
<div style="padding: 3px;"><strong>Reserve me the next available slot:</strong> {{ $details['reserveLogo'] }}</div>
<div style="padding: 3px;"><strong>DISPLAY WINDOW Headline name:</strong> {{ $details['windowHeadline'] }}</div>
<div style="padding: 3px;"><strong>DISPLAY WINDOW text:</strong> {{ $details['windowText'] }}</div>
<div style="padding: 3px;"><strong>YOUR WEBSITE link address:</strong> {{ $details['websiteLink'] }}</div>
</body>
</html>
