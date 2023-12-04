<?php

namespace ZT\Includes\Elementor\Widgets;

use Elementor\Controls_Manager;

class ClientSliderVertical extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'client-slider-vertical';
    }

    public function get_title()
    {
        return __('Client Slider Vertical', 'ahoaloe-plugin');
    }

    public function get_icon()
    {
        return 'fas fa-archive';
    }

    public function get_categories()
    {
        return ['zt-category'];
    }

    protected function register_controls()
    {


        $this->start_controls_section(
            '_section_style',
            [
                'tab' => Controls_Manager::TAB_ADVANCED,
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {


        $clients_1 = [
            [
                'alt' => 'All Prime',
                'img' => 'all_prime.png',
            ],
            [
                'alt' => 'Bate Forte',
                'img' => 'bate_forte.png',
            ],
            [
                'alt' => 'Crosfit Saúde',
                'img' => 'cfs.png',
            ],
            [
                'alt' => 'Comexi',
                'img' => 'comexi.png',
            ],
            [
                'alt' => 'Darthel',
                'img' => 'darthel.png',
            ],
            [
                'alt' => 'Dudalina',
                'img' => 'dudalina.png',
            ],
            [
                'alt' => 'Editora Saraiva',
                'img' => 'editora_saraiva.png',
            ],
            [
                'alt' => 'Ezdoor',
                'img' => 'ezdoor.png',
            ]
        ];

        $clients_2 = [
            [
                'alt' => 'Gedore',
                'img' => 'gedore.png',
            ],
            [
                'alt' => 'Grendene',
                'img' => 'grendene.png',
            ],
            [
                'alt' => 'Grupo Pereira',
                'img' => 'grupo_pereira.png',
            ],
            [
                'alt' => 'Kroton',
                'img' => 'kroton.png',
            ],
            [
                'alt' => 'Livrarias Prime',
                'img' => 'livrarias_prime.png',
            ],
            [
                'alt' => 'Maltec',
                'img' => 'maltec.png',
            ],
            [
                'alt' => 'Maxiaço',
                'img' => 'maxiaco.png',
            ],
            [
                'alt' => 'Newsul',
                'img' => 'newsul.png',
            ]
        ];

        $clients_3 = [
            [
                'alt' => 'Promo Livros',
                'img' => 'promo_livros.png',
            ],
            [
                'alt' => 'R9 Design',
                'img' => 'r9_design.png',
            ],
            [
                'alt' => 'Serra Inox',
                'img' => 'serra_inox.png',
            ],
            [
                'alt' => 'Somos Educação',
                'img' => 'somos_educacao.png',
            ],
            [
                'alt' => 'Soprano',
                'img' => 'soprano.png'
            ],
            [
                'alt' => 'OAB Vargem Grande Paulista',
                'img' => 'oab_vgp.png',
            ],
            [
                'alt' => 'Ortobras',
                'img' => 'ortobras.png',
            ],
            [
                'alt' => 'Piteira',
                'img' => 'piteira.png',
            ]
        ];

        $clients_4=[
            [
                'alt' => 'Play',
                'img' => 'play.png',
            ]
        ]

        ?>

        <section class="splide" aria-label="">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide">
                        <div class="flex gap-4">
                            <?php foreach ($clients_1 as $client) : ?>
                                <img src="<?php echo get_template_directory_uri() . "/dist/images/clientes/" . $client['img'] ?>" alt="<?php echo $client['alt'] ?>">
                            <?php endforeach; ?>
                        </div>
                    </li>
                    <li class="splide__slide">
                        <div class="flex gap-4">
                            <?php foreach ($clients_2 as $client) : ?>
                                <img src="<?php echo get_template_directory_uri() . "/dist/images/clientes/" . $client['img'] ?>" alt="<?php echo $client['alt'] ?>">
                            <?php endforeach; ?>
                        </div>
                    </li>
                    <li class="splide__slide">
                        <div class="flex gap-4">
                            <?php foreach ($clients_3 as $client) : ?>
                                <img src="<?php echo get_template_directory_uri() . "/dist/images/clientes/" . $client['img'] ?>" alt="<?php echo $client['alt'] ?>">
                            <?php endforeach; ?>
                        </div>
                    </li>
                    <li class="splide__slide">
                        <div class="flex gap-4">
                            <?php foreach ($clients_4 as $client) : ?>
                                <img src="<?php echo get_template_directory_uri() . "/dist/images/clientes/" . $client['img'] ?>" alt="<?php echo $client['alt'] ?>">
                            <?php endforeach; ?>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="splide__arrows">
            </div>
        </section>

        <?php

    }
}
