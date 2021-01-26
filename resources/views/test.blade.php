<p style="display: none">{{ $role1 = utf8_encode('Алтаев Данияр') }}</p>
                    <p style="display: none">{{ $role2 = utf8_encode('Жакупова Айгуль Ильясовна') }}</p>
                    <p style="display: none">{{ $role3 = utf8_encode('Абаев Анзор') }}</p>
                    <p style="display: none">{{ $role4 = utf8_encode('Жанбыршы Алмас Маликович') }}</p>
                    <div style="padding: 15px; align-content: center">
                        <div style="padding: 15px; display: inline">
                            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($role1)) !!}" height="100">
                        </div>
                        <div style="padding: 15px; display: inline">
                            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($role2)) !!}" height="100">
                        </div>
                        <div style="padding: 15px; display: inline">
                            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($role3)) !!}" height="100">
                        </div>
                        <div style="padding: 15px; display: inline">
                            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($role4)) !!}" height="100">
                        </div>

                    </div>