<?php
ob_start();
?>

<!-- <style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    thead td {
        border: 1px solid black;
        padding: 5px;
        border-bottom: none;
        /* Remove the bottom border for thead cells */
    }

    tbody td {
        border: 1px solid black;
        padding: 5px;
        border-top: none;
        /* Remove the top border for tbody cells */
    }

    thead .logo-cell {
        padding: 0;
        margin: 0;
        vertical-align: middle;
    }

    tbody tr:first-child td {
        border-top: 1px solid black;
        /* Add top border for the first row in tbody */
    }
</style>

<table>
    <thead>
        <tr>
            <td rowspan="5" class="logo-cell">LOGO</td>
        </tr>
        <tr>
            <td rowspan="4">MONITOR DE L & D DE ESTRUCTURAS FISICAS</td>
            <td>LBS-PHS-FR-01</td>
        </tr>
        <tr>
            <td>Versión: 01</td>
        </tr>
        <tr>
            <td>Página: 01</td>
        </tr>
        <tr>
            <td>Fecha:</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>holaa</td>
        </tr>
        <tr>
            <td>holaa</td>
        </tr>
    </tbody>
</table> -->
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    thead {
        width: 100%;
    }

    thead th {
        border: 1px solid black;
    }

    tbody td {
        border: 1px solid black;
    }
</style>

<table>
    <!-- <thead>
        <tr>
            <th rowspan="4" style="border-right: none;">Columna 1</th>
            <th rowspan="4" style="border-left: none;">Columna 2</th>
            <th>Fila 1</th>
        </tr>
        <tr>
            <th>Fila 2</th>
        </tr>
        <tr>
            <th>Fila 3</th>
        </tr>
        <tr>
            <th>Fila 4</th>
        </tr>
    </thead> -->
    <tbody>
        <tr>
            <td rowspan="2">Zonas/areas</td>
            <td rowspan="2">Infraestructura, accesorios complementarios</td>
            <td colspan="4">Diario</td>
            <td colspan="4">Interdiario</td>
            <td colspan="4">Semanal</td>
            <td colspan="4">Quincenal</td>
            <td colspan="4">Mensual</td>
            <td rowspan="2">Responsable de ejecución</td>
        </tr>
        <tr>
            <td colspan="6">S1</td>
            <td colspan="6">S2</td>
            <td colspan="6">S3</td>
            <td colspan="6">S4</td>
            <td colspan="4">S1</td>
            <td colspan="4">S2</td>
            <td colspan="4">S3</td>
            <td colspan="4">S4</td>
            <td>S1</td>
            <td>S2</td>
            <td>S3</td>
            <td>S4</td>
            <td>S1</td>
            <td>S2</td>
            <td>S3</td>
            <td>S4</td>
            <td>S1</td>
            <td>S2</td>
            <td>S3</td>
            <td>S4</td>
        </tr>
        <tr>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <!-- <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td> -->
            <!-- <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td>
            <td>xxx</td> -->
        </tr>


        <!-- <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>7</td>
            <td>8</td>
            <td>9</td>
            <td>10</td>
            <td>11</td>
            <td>12</td>
            <td>13</td>
            <td>14</td>
            <td>15</td>
            <td>16</td>
            <td>17</td>
            <td>18</td>
            <td>19</td>
            <td>20</td>
            <td>21</td>
            <td>22</td>
            <td>23</td>
            <td>24</td>
            <td>25</td>
            <td>26</td>
            <td>27</td>
            <td>28</td>
            <td>29</td>
            <td>30</td>
            <td>31</td>
            <td>32</td>
            <td>33</td>
            <td>34</td>
            <td>35</td>
            <td>36</td>
            <td>37</td>
            <td>38</td>
            <td>40</td>
            <td>41</td>
            <td>42</td>
            <td>43</td>
            <td>44</td>
            <td>45</td>
            <td>46</td>
            <td>47</td>
            <td>48</td>
            <td>49</td>
            <td>50</td>
            <td>51</td>
            <td>52</td>
            <td>53</td>
            <td>54</td>
            <td>55</td>
        </tr> -->
    </tbody>
</table>

<?php
$html = ob_get_clean();

require_once '../assets/DomPDF/autoload.inc.php';

use Dompdf\Dompdf;

// Create an instance of Dompdf
$dompdf = new Dompdf();

// Load the HTML content into Dompdf
$dompdf->loadHtml($html);

// Set the paper size and orientation
$dompdf->setPaper('A3', 'landscape');

// Render the HTML content to PDF
$dompdf->render();

// Display the PDF in the browser
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="profesionales.pdf"');
header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
header('Pragma: public');
header('Content-Length: ' . $dompdf->output(null, true));

echo $dompdf->output(null, true);
?>