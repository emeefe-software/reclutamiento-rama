@extends('layouts.admin.admin')
@section('description')

<p class="text-center text-muted mb-4">
    Lo esencial que debes de saber ahora que eres parte de <strong>RAMA Redes de Valor</strong>
</p>

<hr>

<h4 class="mt-4">💫 <strong>SOMOS</strong></h4>
<p>
    Somos una organización multidisciplinar que alberga equipos de trabajo, cuyo principal objetivo es desarrollar proyectos y estrategias integrales para distintos sectores.
    Bajo el lema <em>“Pensamos negocios y los hacemos posibles”</em>, impulsamos el crecimiento y desarrollo de las empresas brindándoles las herramientas necesarias para materializarlas, posicionarlas y consolidarlas.
</p>
<blockquote class="blockquote text-center">
    <p class="mb-0">
        “La utopía está en el horizonte. Camino dos pasos, ella se aleja dos pasos y el horizonte se corre diez pasos más allá.
        ¿Entonces para qué sirve la utopía? Para eso, sirve para caminar.”
    </p>
    <footer class="blockquote-footer">Eduardo Galeano</footer>
</blockquote>

<h4 class="mt-4">📌 <strong>QUÉ HACEMOS</strong></h4>
<p>
    Somos un equipo multidisciplinar, sustentable, productivo y plenamente humano que desarrolla proyectos y estrategias integrales para impulsar el crecimiento y posicionamiento de empresas.
    Brindamos soluciones innovadoras y herramientas efectivas que mejoran la experiencia de sus clientes, transformando ideas en negocios exitosos.
</p>

<h4 class="mt-4">🎯 <strong>A DÓNDE QUEREMOS LLEGAR</strong></h4>
<p>
    En los próximos tres años, seremos una empresa autosuficiente y productiva, con una participación en la generación de proyectos exitosos tanto social como económicamente en México y Latinoamérica.
    Enfocándonos en los sectores de la salud y la industria automotriz, impulsando soluciones innovadoras que mejoren la vida de las personas y fortalezcan la competitividad de las empresas RAMA y la de nuestros clientes.
    Contaremos con un equipo de trabajo consolidado y comprometido, con baja rotación, que potenciará nuestra capacidad productiva y nos permitirá alcanzar nuestros objetivos con eficiencia, creatividad y un profundo compromiso social.
</p>

<h4 class="mt-4">🚀 <strong>CÓMO LOGRARLO</strong></h4>
<p>
    En RAMA, creemos que el camino hacia el éxito de nuestros proyectos y estrategias pasa por la integración de valores fundamentales en cada etapa de nuestro trabajo.
    <strong>La colaboración</strong> es esencial, ya que trabajamos como un equipo multidisciplinario que se apoya mutuamente para generar soluciones innovadoras.
    <strong>El respeto y la responsabilidad</strong> nos guían a actuar con integridad, asegurando que cada decisión esté alineada con los intereses de nuestros clientes y las mejores prácticas del sector.
</p>
<p>
    Fomentamos la <strong>autonomía</strong> dentro de un marco de trabajo conjunto, brindando a cada miembro la libertad y confianza para tomar decisiones que impulsen la creatividad y la innovación.
    <strong>La eficiencia</strong> es clave para materializar los proyectos de manera ágil, garantizando resultados rápidos sin comprometer la calidad.
    La <strong>creatividad</strong> se manifiesta en la búsqueda constante de soluciones originales y en la adaptación a las nuevas demandas del mercado.
</p>
<p>
    A lo largo de nuestro trabajo, mantenemos un nivel alto de <strong>profesionalismo</strong>, asegurando que cada paso esté respaldado por la experiencia y el conocimiento, con un compromiso firme hacia la excelencia.
    Y, por último, el <strong>humanismo</strong> es el pilar que nos permite poner a las personas en el centro de nuestras soluciones, entendiendo sus necesidades y construyendo relaciones duraderas basadas en confianza y empatía.
</p>

<h4 class="mt-4">🧑‍💻 <strong>MIEMBROS DEL EQUIPO</strong></h4>
<p>
    Ser miembro de RAMA es formar parte de un equipo que se distingue por su pasión, por su espíritu creativo e innovador.
    Donde el desarrollo profesional y personal es fundamental, y donde cada integrante tiene la oportunidad de aprender, crecer y enfrentar nuevos retos.
    Aquí, cada miembro se convierte en un actor clave para transformar ideas en proyectos exitosos, disfrutando de una experiencia única que fomenta el crecimiento, el compañerismo y la constante evolución.
    En RAMA, cada paso construye un futuro lleno de logros compartidos y aprendizajes constantes.
</p>

<div class="row">
    @foreach ($team as $member)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100 border-primary">
                <div class="card-body">
                    <h5 class="card-title text-primary">
                        👤 {{ trim($member->first_name) . ' ' . trim($member->last_name) }}
                    </h5>
                    <p class="card-text mb-1">
                        <strong>Área:</strong> {{ $member->area }}
                    </p>
                    <p class="card-text mb-1">
                        <i class="fas fa-phone-alt"></i> {{ $member->phone }}
                    </p>
                    <p class="card-text">
                        <i class="fas fa-envelope"></i> {{ $member->email }}
                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>

<h4 class="mt-4">📝 <strong>TAREAS INICIALES</strong></h4>
<p class="mb-2">
    Puedes encontrar los documentos necesarios para estas tareas en el siguiente enlace:
    <br>
    <a href="https://onedrive.live.com/?redeem=aHR0cHM6Ly8xZHJ2Lm1zL2YvcyFBcFVUWUVpQ1o5dmxoZkFrd3RoeVdScDdKN0JfbHc%5FZT0yUnBlRVo&id=E5DB678248601395%2196292&cid=E5DB678248601395" target="_blank" class="btn btn-sm btn-primary mt-2">
        📂 Acceder a documentos
    </a>
</p>
<ul class="list-group mb-4">
    <li class="list-group-item">
        <i class="fas fa-print text-primary"></i> Imprimir, firmar y subir <strong>acuse de aceptación de reglamento</strong>
    </li>
    <li class="list-group-item">
        <i class="fas fa-file-signature text-primary"></i> Leer, imprimir, firmar y subir <strong>acuerdo de confidencialidad</strong>
    </li>
    <li class="list-group-item">
        <i class="fas fa-book-open text-primary"></i> Leer <strong>Nomenclatura de archivos</strong>
    </li>
    <li class="list-group-item">
        <i class="fas fa-book text-primary"></i> Leer <strong>Reglamento</strong>
    </li>
</ul>

@endsection