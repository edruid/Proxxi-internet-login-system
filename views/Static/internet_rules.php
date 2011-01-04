<h1>Nyttjandeavtal för internetanslutning samt datorer</h1>
<p>
Detta nyttjandeavtal reglerar ansvar för nyttjande av föreningen Ixs internetanslutning
samt datorer. Detta avtal gäller mellan privatpersonen <u><?=$logged?$current_user:'____________________________'?></u> och föreningen Ix genom dess
firmatecknare. Efter att privatpersonen godkänt avtalet
genom att skriva under, skapar föreningen ett användarkonto som ger privatpersonen
tillgång till internet via föreningens internetuppkoppling.
</p>
<p>
Om skada uppstår för föreningen på grund av otillåtna aktiviteter gjorda under en
inloggning gjord med privatpersonens konto har föreningen rätt att utkräva full ersättning av
privatpersonen. Vid brott mot avtalet kan föreningen tillfälligt eller permanent stänga ned
privatpersons konto. Privatpersonen är ansvarig för användning av användarkontot som
skadar annan än föreningen.
</p>

<p>
Privatpersonen ansvarar för att hålla sina inloggninguppgifter hemliga. Vid misstanke om
att uppgifterna blivit spridda måste privatpersonen kontakta föreningen.
</p>
<p>
I det fall privatpersonen upptäcker att andra personer bryter mot reglerna i detta avtal är
privatpersonen skyldig att rapportera överträdelserna till föreningen.
</p>
<p>
Privatpersonen får rätt att med uppkopplingen till internet sköta sina email samt annan
personlig icke-kommersiell kommunikation som inte är olaglig eller kränkande.
</p>
<p>
Under nyttjande av uppkoppling och datorer tillåts särskillt ej följande:
</p>
<ol>
<li>Aktiviteter som inte är förenliga med syftesparagraferna i föreningarna Proxxi eller Ixs stadgar.</li>
<li>Aktiviteter som bryter mot spelföreningen Proxxis jämställdhetspolicy.</li>
<li>Aktiviteter som skadar eller stör föreningen Ixs datorer eller datornät.</li>
</ol>
<p>Privatpersonen ansvarar för att hålla sig uppdaterad gällande innehållet i ovan nämnda
stadgar samt jämställdhetspolicy. Privatpersonen förbinder sig härmed att följa avtalets
regler.</p>

<table>
<tr>
<td>Ort och datum:</td>
<td>Stockholm, 2011-01-03</td>
</tr>
<tr>
<td><p><i>Privatpersonen</i></p></td>
</tr>
<tr>
<td>Personnummer:</td>
<td><?=$logged?$current_user->personnummer:'<u>_________________</u>-<u>__________</u>'?></td>
</tr>

<tr>
<td>Underskrift:</td>
<td><u>____________________________</u></td>
</tr>
<tr>
<td>Namnförtydligande:</td>
<td><?=$logged?$current_user:'<u>____________________________</u>'?></td>
</tr>
<tr>
<td>Användarnamn:</td>
<td><?=$logged?$current_user->username:'<u>____________________________'?></td>

</tr>
<? if(!$is_18): ?>
<tr>
<td><p><i>Målsman</i></p></td>
</tr>
<tr>
<td>Målsmans underskrift:</td>
<td>____________________________</td>
</tr>
<tr>
<td>Namnförtydligande:</td>
<td>____________________________</td>
</tr>
<? endif ?>
<tr>
<td><p><i>Firmatecknare Ix</i></p></td>
</tr>
<tr>
<td>Personnummer:</td>
<td>____________________________</td>
</tr>
<tr>
<td>Underskrift:</td>
<td>____________________________</td>
</tr>
<tr>

<td>Namnförtydligande:</td>
<td>____________________________</td>
</tr>
</table>
