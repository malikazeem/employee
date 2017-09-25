 <!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
      table {
        border-collapse: collapse;
        width: 100%;
      }
      td, th {
        border: solid 2px;
        padding: 10px 5px;
      }
      tr {
        text-align: center;
      }
      .container {
        width: 100%;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div class="container">
        <div><h2>List of hired employees from {{$searchingVals['from']}} to {{$searchingVals['to']}}</h2></div>
       <table id="example2" role="grid">
            <thead>
              <tr role="row">
                <th width="20%">Name</th>
                
                <th width="10%">PNO</th>
                <th width="20%">City</th>
                <th width="15%">Company Name</th>
                <th width="10%">Zip</th>
                <th width="10%">Hired Date</th>             
              </tr>
            </thead>
            <tbody>
            @foreach ($employees as $employee)
                <tr role="row" class="odd">
                  <td>{{ $employee['First Name'] }} {{$employee['Middle Name']}} {{$employee['Last Name']}}</td>
                  <td>{{ $employee['PNO'] }}</td>
                  <td>{{ $employee['City'] }}</td>
                  <td>{{ $employee['Company Name'] }}</td>
                  <td>{{ $employee['Zip'] }}</td>
                  <td>{{ $employee['Hired Date'] }}</td>
                  
              </tr>
            @endforeach
            </tbody>
          </table>
    </div>
  </body>
</html>