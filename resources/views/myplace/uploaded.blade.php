<div class="panel panel-default">
    <div class="panel-heading">Uploaded</div>
    <div class="panel-body">
        <table class="table" name="movie_table">
            @if ($videos_for_table == '[]')
                <strong>No uploaded videos.</strong>
            @else
                <thead>
                    <tr class"active">
                        <th> 電影名稱 </th>
                        <th> 觀看人數 </th>
                        <th> Upload Time </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tbody-uploaded-list"></tbody>
            @endif
        </table>
        @if ($videos_for_table != '[]')
        <div class="btn-group" id="uploaded-page-btn"></div>
        <script>
            var uploaded_videos = {!! $videos_for_table !!};
            var max_tr_num = 7;
            var video_count = {{$video_count}};
            var page_num = (video_count-1)/max_tr_num;
            videopage(1);
            for (var i=0; i<=page_num; i++) {
                    var btn = document.createElement('button');
                    var num = i+1;
                    btn.value= num;
                    btn.className = 'btn btn-default';
                    btn.addEventListener('click', function(){
                        videopage(this.value);
                    });
                    btn.innerHTML = num;
                    document.getElementById('uploaded-page-btn').appendChild(btn);
            }
            function videopage(page) {
                if (!String.format) {
                    String.format = function(format) {
                        var args = Array.prototype.slice.call(arguments, 1);
                        return format.replace(/{(\d+)}/g, function(match, number) { 
                        return typeof args[number] != 'undefined' ? args[number] : match;
                        });
                    };
                }
                var tbody_append_string_format =
                `
                    <td>
                        <a href="/video/{0}" style="color: #23527c">{1}</a>
                    </td>
                    <td>
                        <p>{2}</p>
                    </td>
                    <td>
                        <p>{3}</p>
                    </d>
                    <td>
                        <form method="POST" action="/myplace/uploaded/{0}">
                            {{ csrf_field() }}
                            <button class="btn btn-danger" type="submit"> 
                                <i class="fa fa-btn fa-video-camera"></i>Delete
                            </button>
                            <input name="_method" type="hidden" value="DELETE">
                        </form>
                    </td>
                `;
                var index = (page-1)*max_tr_num;
                var tr_num = 0;
                document.getElementById('tbody-uploaded-list').innerHTML = "";
                while(tr_num<max_tr_num) {
                    if (index >=  video_count) {
                        break;
                    }
                    var tr = document.createElement('tr');
                    tr.className = 'active';
                    tr.innerHTML = String.format(tbody_append_string_format, uploaded_videos[index]['id'],
                                        uploaded_videos[index]['name'], uploaded_videos[index]['views'], 
                                        uploaded_videos[index]['created_at']);
                                        console.log(uploaded_videos[index]['id']);
                    document.getElementById('tbody-uploaded-list').appendChild(tr);
                    tr_num++;
                    index++;
                }
            }
            var page_now = 1;
            function changePage(change_page) {
                if (page_now != changePage) {
                    var xmlHttp = new XMLHttpRequest();
                    xmlHttp.onreadystatechange = function() { 
                        if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
                            console.log(xmlHttp.responseText);
                    }
                    xmlHttp.open("GET", "/", true); // true for asynchronous 
                    xmlHttp.send(null);
                }
            }
        </script>
        @endif
    </div>
</div>
