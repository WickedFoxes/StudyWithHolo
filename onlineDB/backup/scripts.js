function get_update_sql() {
    var update_string = "";

    var timeArray = new Array();
    $("input[name=str_timeline]").each(function () {
        timeArray.push($(this).val());
    });
    var subArray = new Array();
    $("input[name=subtittle]").each(function () {
        subArray.push($(this).val());
    });
    var textArray = new Array();
    $("input[name=text]").each(function () {
        textArray.push($(this).val());
    });
    var idArray = new Array();
    $("input[name=videoID]").each(function () {
        idArray.push($(this).val());
    });

    for(var i=0; i<timeArray.length; i++){
      if(timeArray[i]===null&&subArray[i]===null&&textArray[i]===null){
        update_sql = "DELETE FROM studydata WHERE id";
      }
      else{
        update_sql = "UPDATE studydata SET str_timeline='"+timeArray[i]+
        "',"+"subtittle='"+subArray[i]+
        "',"+"text='"+textArray[i]+
        "' WHERE id="+idArray[i] + ";";
      }
      update_string += update_sql;
    }
    document.getElementById("updateSQL").value=update_string;
  }