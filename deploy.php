<? php
/ **
 * SCRIPT DE IMPLANTAÇÃO GIT
 *
 * Usado para implantar sites automaticamente via GitHub
 * Com base em: https://gist.github.com/oodavid/1809044
 * /
$ key  =  ' [SET_YOUR_RANDOM_KEY] ' ;
if ( $ _GET [ ' chave ' ] ! =  $ chave ) {
    cabeçalho ( ' Localização: ./ ' );
    morrer ();
}
    
// matriz de comandos
$ command  =  array (
    ' eco $ PWD ' ,
    ' whoami ' ,
    ' git checkout -. ' ,
    ' git pull ' ,
    ' status git ' ,
    ' sincronização do submódulo git ' ,
    ' atualização do sub-módulo git ' ,
    ' status do sub-módulo git ' ,
);
chdir ( " / home / [SET_PATCH_TO_PROJECT] / public_html " );
// comandos exec
$ output  =  ' ' ;
foreach ( $ comandos  AS  $ comando ) {
    $ tmp  =  shell_exec ( comando $ );
    
    $ output  . =  " <span style = \" color: # 6BE234; \ " > \ $ </span> <span style = \" color: # 729FCF; \ " > { $ command } \ n </span> <br /> " ;
    $ output  . =  htmlentities ( trim ( $ tmp )) .  " \ n <br /> <br /> " ;
}
? >

<! DOCTYPE HTML>
< html  lang = " pt-BR " >
< cabeça >
    < meta  charset = " UTF-8 " >
    < title > SCRIPT DE IMPLANTAÇÃO GIT </ title >
</ cabeça >
< body  style = " cor do plano de fundo : # 000000 ; cor : #FFFFFF ; peso da fonte : negrito ; preenchimento : 0  10 px ; " >
< div  style = " width : 700 px " >
    < div  style = " float : left ; width : 350 px ; " >
    < p  style = " color : white ; " > Script de implantação do Git </ p >
    <? php echo $ output ; ? >  
    </ div >
</ div >
</ corpo >
</ html >