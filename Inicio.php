<?php
    require_once("views/includes/header.php");
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnicos y Asociados</title>
    <link rel="stylesheet" href="Assets/css/inicio.css">
</head>

<body>  
    <main class="main-content">
        <section class="hero">
            <h1>Bienvenido a Tecnicos y Asociados</h1>
            <p>Te ayudamos a encontrar un tecnico para arreglar tu dispositivo en tiempo record</p>
            <a href="Index.php?accion"><button class="btn btn-login">Empezar ahora</button></a>
        </section>
        
        <section class="features">
            <article class="feature-card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSamHeMYQ8nCOH82kWTvlVr8emS0NTU3a8Gd8YiL2wsC_fhItbzWdEC5tX4cXJH6l3m_C0&usqp=CAU" alt="Foto de algun tencino ahi vemos en clase">
                <h3>Benito Camelo</h3>
                <p>Tecnico del caiocelular de los mas rapidos</p>
            </article>
            
            <article class="feature-card">
                <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxMTEBISEhAVFRUXFRUWFxcSEhgVFhUVFhIWGBUYFRkaHSggGBolGxcVIjEhJSkrLi4uFx8zODMtNygtLisBCgoKDg0OGhAQGi0mICUtLS0tLS0tLS0tKy0tLS0wLS0tLS0tLS0tLSsvLS0tLSstLS0tLS0tLS0tLS0tLS0vLf/AABEIAKMBNgMBEQACEQEDEQH/xAAbAAEAAgMBAQAAAAAAAAAAAAAABQYCAwQBB//EADoQAAIBAgMECAMGBQUAAAAAAAABAgMRBCExBRJBUQYiYXGBkaGxEzLBQlLR4fDxM2JygqIUIzRDkv/EABsBAQACAwEBAAAAAAAAAAAAAAACBAEDBQYH/8QAMBEBAAIBAwIDBgYDAQEAAAAAAAECAwQRIRIxBUFREzJhcZGxIjOhweHwUoHRBhT/2gAMAwEAAhEDEQA/ALAdB5IAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABhVqxirykornJpLzYZiJniHLHa+HbssTRb5KtDj4mOqPVP2WT/GfpLtTMtYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHDjMY7uMLX4yaul2JcX6Lt0K2fUxj4ju6eh8Otn/Hbiv6yg9pbHp1c6rnOX3pSd13LRLsSsc62e1p5l6LFo8eOu1Y2U/bHRlx61J7yzyetvqZrmjtJfTz3qjtjdIcRhJrcm3BPrUpvqNcVb7D7V430LdMk17Odn0tMvvRz6+b69sbalPE0Y1qTunqn80ZLWMlwa/MuVtFo3h5/LitjtNbO0k1gAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADXiau7Bytey0XF8EQyXileqW/T4LZskUr/YV3CbWjOThKLhPN21v3M4uWJ97u9ng6YiKRG2ztrQbRX6lrpQuJebRmBWukWAg4/EStNNX7V+JZxWnsqaikTy5+g+2XhsXGMnanVahNPRSbtCXenl3N8i/hvtLi67B7THvHeP7L7AXHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAET0hoSqU9yMnFXTbi7N24XOfqc0Tfo9Ho/C9JNMc5Z727fL+fsjNnUKcMQnTdR00r3rWcoNfN1lk0+GncVMtqw6+OtpjaUft/pIm3Gm9xp6viaoiJ8m2d4juhIbXqrOtBSg/+yHC/Fon0Vn3Za/aXj3o/227Vkt31M07mSN4VDaOUm0+1PiWaSpWh98pt2V9bK/fbM6byLIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAYmdo3SrHVMR6tbcZWTa8WrHAn1l7uI24hH7efwounC3OVrZ+Rq8+W+vZQ8dspSqKau01Z2eaN9MvTO0tOTF1cwwxdFfEXwKMoRUUpJzlNSay3ustXxV3oStat+WutLU4md3HjJO1vAjTunfs0bB2Z/qMdRp6xUlOeV1uQabv2N2j/ci9gr1TDka7J7PHM/6+r7MdB5kAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA1152i33LzdvqQyTtSfk36WvVmpHxhW5YKU4XlWqQk31XFpR1yys8u/U5HG72taWtCvbV2jiKdXeylG1pu8m7r7Sjey52RHorPwlmb2r8Yd+yK8HDN718787mi9W6lt44MdjoQTshXgtyrKqX3pu2V7J6N/sbo4au629AqT+JXnuRS3aSuo57zTlKN+SvHzRf0W87y4PjnTHRHnz/f78VzLzz4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABHdIcYqOHnNptKyy4NtWZqyzHTMeq3oqWnNW0RxE8yiMVthwpwlBxlGVurLk+KfDU5fT6vYVydPMKptXHXk7xhF/wAreXLQjEp3tM93Bg6+6rLLilmteKvwZjJyjijZhiMTd2vn+r3MVp5l7+ULTsPofKVOM6rUFL7DjvSS4N3yUnfll6FumktbmZ2cjN4xTFM0pXq289+N/ouuCwkaUFCCslzzbfFt8WX6UilemrgZ89815veeZbybSAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAce2KqVCpCSvGcXFpq+vEo63aIifN3fA+ub3rt+Hbn5/zG6l4LZUKUVuqU5JW36rtbsiuHgmznXyzZ6HHhrVw7QoVYLLcbbuovnyv+QrtulbfbhW8TtGrVa31ZpbqSysr6FnpiFXrtPlsnehOz1VxUFLNRTqS/mcbWT7LtGzBXrvET5cqfiGWcWCZjvPH1/h9VOk8qAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGmpFN2aucfU5OvJPpHD2PhuD2Onj1nmf9/wq+Np/Fq1Z7+5CGSstbZZd+ZVdJA4ijSjnL4kpcHK/nfREt5RiOVer1PiSUmkskrRvbK+t3m8zdHEbNFp6p3TfRXaccNVlUlCUk6bilG1770XxaXA3YMsUtMypa7SzqKRWJ253+69dHukEMWpuMJQcGk1O181lazLlNRW07Tw5Go8IzYsftKz1RHfaJ3j47eiYLDkgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAZKDfB+RGb1jvLdTT5r7TSkzv6RLdSwjfHw7e+34la+srHu8uzp//P5rc5pisfDmf+fq3whGMHK2ibz1yKl9Te/w+Tt4PCdNpuduqfWefpHaEJOp1b34P1KrdCAxast1aXf7shKcI3aVe1KUlZu27HvMwxKn0qTTN8y0RWXdGCySV28klm2+SXEhG7ZtvxC29F9lSpQk5K05vnouCfO31Ezu6mmweypz3la41LZa2LGPVXpG3dzNZ4FptRbr5rM99vP5x/zZthO5ewaiMnHm8t4n4Tk0U9Uc09fT5+n2ZFhyAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABI4XAdVSlq9Ivlzf4FPUZ5j8NXovC/C63iMueOPKP3n/jKcE9VZ8HyZzp5etrMx2+jVvtSz8e/mR32lPpiY4YbYmo05tP57JeOvpckrZJ/BtKClVW6l5fQhKvCCxecrPTj3muUoTlHYsPgpVaUZN52lFPdyySvo7GyKzEL+HFWK7WhH1ujmGv/AAV4Skl5bxneWz/58Pp92/CbNp0/kpxj2pZvverMctla0p7sJCnGwJndnYDZRiZiZjmEbVi0TW0bxLckXMesvHvc/d57U/8AndPfecUzWfLzj6d/1eNHQx5K3jeryOq0mXS5Jx5I5/SY9YCasAAAAAAAAAAAAAAAAAAAAAAAAAAB1bMoKdSKeizfcvzsa8t+msyu+H4PbZ61nt3n/SbxGufnyOXZ7eiNq5SkvFdzXA1T32W681iWFaN4qXFZPu4GJjjdKs7W2RG2au84w5R9W/wSHkq6j3tkPtCahHebV31Y37OJCzVVn0e2c5JV6mifUXNr7T8dO0Vr5rWDHvO8rBUldGxbiHBU1IpPIQMMtiiBkohlvpxCMsmgwSRZ015rkj4uR41p6ZdHeZjmsbxPp6/owOu+fAAAAAAAAAAAAAAAAAAAAAAAAAAASewoXlP+n3a/Ar6n3dnZ8E/OtPw/eHbWuu0508PXU2lwYqXy887eGbXl7Gqy1jju24ZprPRkoQvvCqTrb05S7cvp6EZU726rTKu9IK29US4RXrqQnuR2XbCx3KNOPKEV4qKv6k+0OlSu0QxjPMw2tbhmGWSgYGyMAbsnDIG7Km7t9mXovxDE9ic7WXF6L3fcGIjd4jMTtO6N6Ras1ntLFnerPVES+W5sc4slsc+UzH0kMtYAAAAAAAAAAAAAAAAAAAAAAAAAJXo/80+5e7K2p7Q7fgn5l/lH3dmKqWydk+/U59p9XrMdd+yNxK3o2WT1T7VpZ8zVbnstU/DO89nNVxVqU2sm+rb7s3k/e/cKyjqI6YlXK8t1GJUIVvF9ab5t+7Iwn57L5Xq8CTrNUZGEm+KuGG6MTKMy2KIY3YzdgQ0YCXUlJ8ZSfgn+RiOyd++zygnJub1ei+7FaL6vtYYnjhl8VXss+7TzBMPTt4Py6vm/i0ba3J8/2gNrnAAAAAAAAAAAAAAAAAAAAAAAAAA69lyfxYpcbp+V/oas9Ymk7uj4XktTVV6fPifkmpUs8/Y5sw9nFuOHBtCMFnKSX9UreWZqts348kwr2NqxlK8JqSebs7ptaX7c36EIY1OXesVhBbSq8DFlaqFoZ1qf9cfSSYhPHzeFtda7My6sNsJZmEndRMoy6YmUJetgc1edrkZTrCMr4hqFCjFXlNJy7IKzk35peJjybYj8Uyk7J6u/Zw8iTUxbX6VgSzR28UbUiPg+ZeI3i+qyWj/Kf04DYpgAAAAAAAAAAAAAAAAAAAAAAAAA6tmfxoeK/wAWas35cr3hs7aqk/P7S7tq7U3X8OnqvmlyfJdvPl7crJfbiHsoVzHSybeb5vNsqzvKe7ituwN0RtDXM7yg9oVbkZShHYadqsHyb9mZhtwc5ITtDE5h0oS7jkmtGYTdOHmSYl1qoZQ2YVqlrdphmIcG1Kme795Jed7+lyNmyji2VtXDylOs6iztGHVk7U46Wytm7vxRGZ2naWu2ek1jplNUsZSn8tSDfK6v5akt4Ri8T5lSDX7Ze4bN94IaL9cTs6ad8cPnfjePo1t4452niNvL7+s+bI3uSAAAAAAAAAAAAAAAAAAAAAAAAAD1VJR60fmSbXfZ2IZI3rMLWivWmpx2tO0dUb/LflH4d7tOCd77sb31vZXv2nDtD23VvMy1SnvvsQiCZcuNqXy5GZYiEBWleT5Igmjp1LSuSbtLG+RN7LnvxfOPsYdFYNmyvFwfDQyy64RMjbL5e4Hm046X+05L7PWXh+VxJEcqd0sx0p1cPSg/4sGm1wivnt2tWXiY8pt6NGpydEezjvb7eboWGUYpWyRWmFXqap2JQhLyGMqU/kqSj2J5f+Xl6GyCMlq9pWrYuMdWjGcklK7TtpdPXsOzpPyoeQ8byTfVTM+kO4suQAAAAAAAAAAAAAAAAAAAAAAAAAABF4z5t3m/Q5Geu15ez0WTrwUn4R+nBN2RpW0Vj52RGUoQtXKL5swzKLryzXf+vcks6OPxTKb2JPdqRlwkrPvIugtMIbskyQkooMMnEybuOGanTfb5MgnMeah4WV69JS+alGtD/OH5ieypq4iZrb5/sm8VPIjNeFGJ5cLlmQ2SYVuZOqFlj6I/8a/Oc2u7Je6Z2dJ+VDyHi8xOpn5Qmiy5gAAAAAAAAAAAAAAAAAAAAAAAAAPGzEzERvKVa2tMVrG8yjcTNb8pdn0OXnvFr7x2et8PxWxYIpeNp5+7lhJyZXX3FtKPHkRmEolBY2qZiEZlEOd5Lu+v7CV/RxxMrJsaGRGF2Vqw7vBX1WT+hIddCeVuQJhuczKOyK2jX+HUhPg8n3MhPdtr22UjbD+DtCT+zUjvLvaV/YlMb1c7VTNb9PlLthiN9dhieypHccjWm0YmpkydY4a7SvGxaW5h6Mf5It97V36tncxV6aRHweH1d+vPe3xl2mxXAAAAAAAAAAAAAAAAAAAAAAAAABqxLtBv9amjUxvisveHTMaqm3r+yIxz487+5yI7PXz3ebOWRKCUbt2WQkhWcRIMT3RCm7yz0mreKz9kSmOFvTWnt8Vt2FJ2NbprXhXn/b7Bl1QefgB5KT9TLCF6RSfwH4EZZqq3SJbzwjlm7SV+zIlE8Sp66Inpd1GCUcka91PZrm8zA58X8rNkdmq3d9KgrJJcl7HeeCmd2QYAAH//2Q==" alt="Lo mismo de arriba">
                <h3>Jonatan joestars</h3>
                <p>Disponible 24/7 De los mas mejores de la ciudad</p>
            </article>
            
            <article class="feature-card">
                <img src="https://content.imageresizer.com/images/memes/I-robot-Tesla-meme-96v08g.jpg" alt="lo mismo que el de arriba del de arriba">
                <h3>Daniel Domingo</h3>
                <p>Tecnico indie, lo mas nuevo en tecnologia</p>
            </article>
        </section>
    </main>
</body>
</html>
