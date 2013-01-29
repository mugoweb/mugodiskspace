{def $pathsToDrive  = ezini( 'PathToDrive', 'path', 'mugodiskspace.ini' )}

<h2>Disk Usage</h2>

<table cellspacing="0" cellpadding="0" border="0" class="list">
    <tbody>
    <tr>
        <th>Path</th>
        <th>Total</th>
        <th>Used</th>
        <th>Remaining</th>
    </tr>
    {def $diskStats = array()}
    {foreach $pathsToDrive as $pathToDrive}
        {set $diskStats = getDiskSpace( $pathToDrive )}
        <tr class="bglight">
            <td>
                {$pathToDrive}
            </td>
            <td>
                {$diskStats.total}
            </td>
            <td>
                {$diskStats.used}
            </td>
            <td>
                {$diskStats.free}
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>