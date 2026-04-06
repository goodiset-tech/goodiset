import Link from "next/link";
import Image from "next/image";

export default function HeroSection() {
  return (
    <section className="relative bg-gradient-to-br from-[#fff5f5] to-[#ffe8e8] overflow-hidden">
      {/* Background decorations */}
      <div className="absolute inset-0 overflow-hidden">
        <div className="absolute -top-20 -right-20 w-96 h-96 bg-[#e63946]/10 rounded-full blur-3xl" />
        <div className="absolute -bottom-20 -left-20 w-96 h-96 bg-[#ffd700]/10 rounded-full blur-3xl" />
      </div>

      <div className="container relative">
        <div className="flex flex-col lg:flex-row items-center min-h-[500px] lg:min-h-[600px] py-12 lg:py-0">
          {/* Text Content */}
          <div className="flex-1 text-center lg:text-left z-10">
            <span className="inline-block bg-[#e63946] text-white text-sm font-medium px-4 py-1 rounded-full mb-4">
              Premium Swedish Candy
            </span>
            <h1 className="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
              Discover the <span className="text-[#e63946]">Sweetest</span> Treats from Sweden
            </h1>
            <p className="text-lg text-gray-600 mb-8 max-w-xl mx-auto lg:mx-0">
              Indulge in authentic Scandinavian candies, chocolates, and sweets. 
              Handpicked favorites delivered right to your doorstep in the UAE.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
              <Link
                href="/shop"
                className="inline-flex items-center justify-center px-8 py-3 bg-[#e63946] text-white font-semibold rounded-full hover:bg-[#d62836] transition-colors shadow-lg shadow-[#e63946]/25"
              >
                Shop Now
              </Link>
              <Link
                href="/category/pick-mix"
                className="inline-flex items-center justify-center px-8 py-3 bg-white text-gray-900 font-semibold rounded-full hover:bg-gray-100 transition-colors border border-gray-200"
              >
                Build Your Box
              </Link>
            </div>
          </div>

          {/* Hero Image */}
          <div className="flex-1 relative mt-8 lg:mt-0">
            <div className="relative w-full max-w-lg mx-auto">
              <Image
                src="/front/assets/images/candy-bg.webp"
                alt="Swedish Candy Collection"
                width={600}
                height={500}
                className="w-full h-auto object-contain"
                priority
              />
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
