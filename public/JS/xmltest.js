
function WriteToFile(links, rechts, optimaalcurve) {
    var customLabels = ['125', '250', '500', '750', '1000', '1500', '2000', '3000', '4000', '6000', '8000'];

    var xmlContent = `<?xml version="1.0" encoding="UTF-8"?>
<PresetXMLTree Version="2">
<Preset Name="Test" GenericType="EQ10">
    <PresetHeader>
        <PluginName>Q10</PluginName>
        <PluginVersion>7.1.0.4</PluginVersion>
        <ReadOnly>False</ReadOnly>
    </PresetHeader>
    <MessageToShell/>
    <PresetData Setup="CURRENT">
        <Parameters Type="RealWorld">`;

    customLabels.forEach((label, index) => {
        var linkDiff = links[index] - optimaalcurve[index];
        if (linkDiff > 0) {
            linkDiff = linkDiff * 0.4;
        } else {
            linkDiff = linkDiff * 0.6;
        }
        xmlContent += `\n            1 0 ${linkDiff.toFixed(1)} ${label} 7`;
    });

    customLabels.forEach((label, index) => {
        var rechtsDiff = rechts[index] - optimaalcurve[index];
        if (rechtsDiff > 0) {
            rechtsDiff = rechtsDiff * 0.4;
        } else {
            rechtsDiff = rechtsDiff * 0.6;
        }
        xmlContent += `\n            1 0 ${rechtsDiff.toFixed(1)} ${label} 7`;
    });

    xmlContent += `
        -12 -12 -6 -6 *
        * * * * *
        0 0 0 0 *
        </Parameters>
    </PresetData>
</Preset>
</PresetXMLTree>`;

    var blob = new Blob([xmlContent], { type: 'text/xml;charset=utf-8;' });
    var downloadLink = document.createElement("a");
    var url = URL.createObjectURL(blob);
    downloadLink.href = url;
    downloadLink.download = 'Wavelab_audiogram.xps';
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
    URL.revokeObjectURL(url);
}

document.getElementById('downloadBtn').addEventListener('click', function () {
    WriteToFile(links, rechts, optimaalcurve);
});