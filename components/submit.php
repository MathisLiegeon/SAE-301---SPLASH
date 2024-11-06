<span class="button form-submit">
<input
type="submit"
name="<?php echo esc_attr($args['name']); ?>"
id="<?php echo esc_attr($args['id']); ?>"
class=" <?php echo esc_attr($args['class']); ?>"
value="<?php echo esc_html($args['text']); ?>"
>
</span>
<!-- How to use -->
<!-- get_template_part('components/submit', null, array(
      'name' => 'wp-submit',
      'id' => 'wp-submit',
      'text' => 'Se connecter',
      'class' => ''
)); -->