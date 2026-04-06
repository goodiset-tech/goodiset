import Image from "next/image";

export default function AboutSection() {
  return (
    <section className="py-16 lg:py-24 bg-[#fef3e2] relative overflow-hidden">
      {/* Background decorations */}
      <div className="absolute top-10 left-10 opacity-60">
        <Image
          src="/front/assets/images/about_left.webp"
          alt=""
          width={200}
          height={171}
          className="w-32 lg:w-48"
        />
      </div>
      <div className="absolute bottom-10 right-10 opacity-60">
        <Image
          src="/front/assets/images/about_right.webp"
          alt=""
          width={200}
          height={171}
          className="w-32 lg:w-48"
        />
      </div>

      <div className="container relative z-10">
        <div className="max-w-3xl mx-auto text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
            Welcome to <span className="text-[#e63946]">Goodiset</span>
          </h2>
          <p className="text-lg text-gray-700 leading-relaxed mb-6">
            At Goodiset, we bring the authentic taste of Scandinavian sweets right to your doorstep. 
            Our carefully curated selection of Swedish candies, chocolates, and treats offers a 
            unique taste experience that you won&apos;t find anywhere else.
          </p>
          <p className="text-lg text-gray-700 leading-relaxed font-medium">
            From the famous Swedish pick and mix tradition to premium chocolate bars and 
            beautifully packaged gift boxes, every product is selected for its quality and 
            authentic Scandinavian heritage.
          </p>
        </div>
      </div>
    </section>
  );
}
